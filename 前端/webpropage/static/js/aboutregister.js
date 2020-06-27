
function getCheckcode(){


  var email=document.getElementById("email");
  if(!checkEmail(email.value)) return;

 $.ajax({
  url:'/sendMail/sendCheckcode',
  type:'post',
  data:{"email":email.value},
  success:function(data) {
       alert(data);
  },
   error:function(data) {
        alert("not found");
   }

 }

 );
 
}




function checkEmail(email) {
    var reg = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/;
    //调用正则验证test()函数
    isok= reg.test(email);
    if(!isok) {
        alert("邮箱格式不正确，请重新输入！");
        return false;
    }
    return true;

}




function registercheck(){
    var id=document.getElementById("id");
    var email=document.getElementById("email");
    var password=document.getElementById("password");
    var name=document.getElementById("name");
    var checkCode=document.getElementById("checkCode");
 
    if(id.value.length==0){
	   alert("请填写账号");
	   return;
	 }
 
    if(email.value.length==0){
	   alert("请填写邮箱号");
	   return;
     }
    else{
       if(!checkEmail(email.value)) return;
     }
 
     if(password.value.length<10){
          alert("请填写足够位数的密码");
          return;
     }
 
 
     if(name.value.length==0){
         alert("请填写昵称");
         return;
     }

    if(checkCode.value.length==0) {
        alert("请填写邮箱验证码");
        return;
    }

 // if(checkCode.value.length==0) {
 // alert("请填写邮箱验证码");
 // return;
 // }


    password=encryptByRSA(password.value,localStorage.getItem('publicKey'));

    $.ajax({
      url:'/user/addUser',
      type:'post',
      data:{"id":id.value,"password":password,"userName":name.value,"email":email.value,"checkCode":checkCode.value},
      success:function(data) {
         alert(data);
         if(data=="注册成功") window.location.href="login.html";
      },
      error: function(data) {
			alert("not found");
      }
   });

}







