#! /bin/bash
# imsettings-target-checker.sh
# Copyright (C) 2013 Akira TAGOH
#
# Authors:
#   Akira TAGOH  <tagoh@redhat.com>
#
# This library is free software; you can redistribute it and/or
# modify it under the terms of the GNU Lesser General Public
# License as published by the Free Software Foundation; either
# version 2 of the License, or (at your option) any later version.
#
# This library is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
# Lesser General Public License for more details.
#
# You should have received a copy of the GNU Lesser General Public
# License along with this library; if not, write to the
# Free Software Foundation, Inc., 51 Franklin Street, Fifth
# Floor, Boston, MA  02110-1301  USA

basename=`basename $0`
basedir=`dirname $0`

if [ -f /usr/libexec/imsettings-functions ]; then
    . /usr/libexec/imsettings-functions
else
    . $basedir/imsettings-functions
fi

dbus_send() {
    dest="$1"
    objpath="$2"
    method="$3"
    exe=`which dbus-send 2>/dev/null || which gdbus 2>/dev/null`
    args=
    if [ "x$exe" = "x" ]; then
	echo "No programs to send a message through DBus"
	exit 1
    fi
    case "`basename $exe`" in
	dbus-send)
	    args="--session --dest=$dest --type=method_call --print-reply $objpath $method"
	    ;;
	gdbus)
	    args="call -e -d $dest -o $objpath -m $method"
	    ;;
	*)
	    echo "$exe isn't supported"
	    exit 1
    esac
    if [ -n "$DEBUG" ]; then
	echo $exe $args
    fi
    $exe $args > /dev/null 2>&1
}

gsettings_get_bool() {
    schema="$1"
    key="$2"
    exe=`which gsettings 2>/dev/null`
    if [ "x$exe" = "x" ]; then
	echo "No gsettings command"
	exit 1
    fi
    if [ -n "$DEBUG" ]; then
	echo $exe get $schema $key
    fi
    ret=`$exe get $schema $key`
    if [ x$ret == "xtrue" ]; then
	return 0
    else
	return 1
    fi
}

case $(get_desktop) in
    *gnome|gnome*)
	dbus_send 'org.gnome.Shell' '/' 'org.freedesktop.DBus.Peer.Ping'
	if [ $? = 0 ]; then
	    if gsettings_get_bool org.gnome.settings-daemon.plugins.keyboard active; then
		log "org.gnome.settings-daemon.plugins.keyboard.active is true. imsettings is going to be disabled."
		exit 0
	    elif [ -f /etc/xdg/autostart/org.gnome.SettingsDaemon.Keyboard.desktop ]; then
		log "org.gnome.SettingsDaemon.Keyboard.desktop exists. imsettings is going to be disabled."
		exit 0
	    else
		exit 1
	    fi
	else
	    exit 1
	fi
	;;
    cinnamon)
	dbus_send 'org.Cinnamon' '/' 'org.freedesktop.DBus.Peer.Ping'
	if [ $? = 0 ]; then
	    if gsettings_get_bool org.gnome.settings-daemon.plugins.keyboard active; then
		log "** org.gnome.settings-daemon.plugins.keyboard.active is true. imsettings is going to be disabled."
		exit 0
	    else
		exit 1
	    fi
	else
	    exit 1
	fi
	;;
    *)
	exit 1
	;;
esac
