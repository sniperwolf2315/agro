const btn_toggle = document.querySelector('.toggle_btn');
const btn_logo = document.querySelector('.logo');


btn_toggle.addEventListener('click',function() {
   const side_bar =  document.getElementById('sidebar');
   const content_ped =  document.getElementById('content_ped');
   // console.log('clickssss');
   side_bar.classList.toggle('active');
   content_ped.classList.toggle('active');
   btn_toggle.style.display="none";
});
btn_logo.addEventListener('click',function() {
   const side_bar =  document.getElementById('sidebar');
   const content_ped =  document.getElementById('content_ped');
   side_bar.classList.toggle('active');
   content_ped.classList.toggle('active');
   btn_toggle.style.display="block";
});

