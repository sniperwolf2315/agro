#!/bin/bash
# xinputinfo.sh
# Copyright (C) 2008-2012 Red Hat, Inc. All rights reserved.

# Authors:
#   Akira TAGOH  <tagoh@redhat.com>

# This library is free software; you can redistribute it and/or
# modify it under the terms of the GNU Lesser General Public
# License as published by the Free Software Foundation; either
# version 2 of the License, or (at your option) any later version.

# This library is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
# Lesser General Public License for more details.

# You should have received a copy of the GNU Lesser General Public
# License along with this library; if not, write to the
# Free Software Foundation, Inc., 51 Franklin Street, Fifth
# Floor, Boston, MA  02110-1301  USA

function is_script() {
    if [ "x$(sed -re '/^[ 	]?*[a-zA-Z0-9_]+=.*/{d};/[ 	]?*#.*/{d}' $1)" = "x" ]; then
	return 1
    else
	return 0
    fi
}

CONFIGDIR="${XDG_CONFIG_HOME:-$HOME/.config}/imsettings"
USER_XINPUTRC="$CONFIGDIR/xinputrc"
SYS_XINPUTRC="/etc/X11/xinit//xinputrc"

# Load up the user and system locale settings
oldterm=$TERM
unset TERM
if [ -r /etc/profile.d/lang.sh ]; then
    # for Fedora etc
    source /etc/profile.d/lang.sh
elif [ -r /etc/default/locale ]; then
    # for Debian
    source /etc/default/locale
elif [ -r /etc/env.d/02locale ]; then
    # for Gentoo
    source /etc/env.d/02locale
fi
[ -n "$oldterm" ] && export TERM=$oldterm

tmplang=${LC_CTYPE:-${LANG:-"en_US.UTF-8"}}

# unset env vars to be safe
unset AUXILIARY_PROGRAM AUXILIARY_ARGS GTK_IM_MODULE ICON IMSETTINGS_IGNORE_ME LONG_DESC NOT_RUN PREFERENCE_PROGRAM PREFERENCE_ARGS QT_IM_MODULE SHORT_DESC XIM XIM_PROGRAM XIM_ARGS IS_XIM

if [ $# -gt 0 ]; then
    source $1
    IMSETTINGS_FILENAME=$1
else
    [ -z "${IMSETTINGS_DISABLE_USER_XINPUTRC-}" ] && IMSETTINGS_DISABLE_USER_XINPUTRC=no
    [ -z "${IMSETTINGS_DISABLE_SYS_XINPUTRC-}" ] && IMSETTINGS_DISABLE_SYS_XINPUTRC=no

    if [ -r "$USER_XINPUTRC" -a "x$IMSETTINGS_DISABLE_USER_XINPUTRC" = "xno" ]; then
	source "$USER_XINPUTRC"
	IMSETTINGS_FILENAME=$USER_XINPUTRC
    elif [ -r "$SYS_XINPUTRC" -a "x$IMSETTINGS_DISABLE_SYS_XINPUTRC" = "xno" ]; then
	source "$SYS_XINPUTRC"
	IMSETTINGS_FILENAME=$SYS_XINPUTRC
    fi
fi
[ "$(basename $IMSETTINGS_FILENAME)" = "$(basename $USER_XINPUTRC)" -a ! -h "$IMSETTINGS_FILENAME" ] && SHORT_DESC="User Specific"
[ "$(basename $IMSETTINGS_FILENAME)" = "$(basename $USER_XINPUTRC).bak" -a ! -h "$IMSETTINGS_FILENAME" ] && SHORT_DESC="User Specific"

[ -z "$XIM" ] && XIM=none
[ -n "$GTK_IM_MODULE" ] && export GTK_IM_MODULE
[ -n "$QT_IM_MODULE" ] && export QT_IM_MODULE
[ -z "$ICON" ] && ICON=imsettings-unknown
# For backward compatibility
[ -z "$IMSETTINGS_IGNORE_ME" ] && IMSETTINGS_IGNORE_ME=$IM_CHOOSER_IGNORE_ME

if [ "`basename $IMSETTINGS_FILENAME`" = "xim.conf" ]; then
    IS_XIM=true
else
    IS_XIM=false
fi
if is_script $IMSETTINGS_FILENAME; then
    IMSETTINGS_IS_SCRIPT=1
else
    IMSETTINGS_IS_SCRIPT=0
fi

cat <<EOF
FILENAME=$IMSETTINGS_FILENAME
LANG=$LANG
AUXILIARY_PROGRAM=$AUXILIARY_PROGRAM
AUXILIARY_ARGS="`echo $AUXILIARY_ARGS | sed -e "s/\\\\([\\"']\\\\)/\\\\\\\\\\\\1/g"`"
GTK_IM_MODULE=$GTK_IM_MODULE
ICON=$ICON
IMSETTINGS_IGNORE_ME=$IMSETTINGS_IGNORE_ME
LONG_DESC="`echo $LONG_DESC | sed -e "s/\\\\([\\"']\\\\)/\\\\\\\\\\\\1/g"`"
QT_IM_MODULE=$QT_IM_MODULE
PREFERENCE_PROGRAM=$PREFERENCE_PROGRAM
PREFERENCE_ARGS="`echo $PREFERENCE_ARGS | sed -e "s/\\\\([\\"']\\\\)/\\\\\\\\\\\\1/g"`"
SHORT_DESC="`echo $SHORT_DESC | sed -e "s/\\\\([\\"']\\\\)/\\\\\\\\\\\\1/g"`"
XIM=$XIM
XIM_PROGRAM=$XIM_PROGRAM
XIM_ARGS="`echo $XIM_ARGS | sed -e "s/\\\\([\\"']\\\\)/\\\\\\\\\\\\1/g"`"
IS_XIM=$IS_XIM
IMSETTINGS_IS_SCRIPT=$IMSETTINGS_IS_SCRIPT
NOT_RUN=$NOT_RUN
EOF
