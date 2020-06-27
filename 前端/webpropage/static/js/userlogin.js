
function logincheck()
{
	var id=document.getElementById("id");
    var password=document.getElementById("password");
    if(password.value.length==0) {
    	alert("请输入密码");
    	return;
    	}
    password=encryptByRSA(password.value,localStorage.getItem('publicKey'));
	$.ajax({
		url:'/user/login',
		type:'post',
		data:{"id":id.value,"password":password},
		complete:function(xhr){
			localStorage.setItem("userToken",xhr.getResponseHeader('userToken'));
		},
		success:function(data)
		  {
			   alert(data);
		  	  if(data=="登录成功") window.location.href="personPage.html";
		  },
		   error:
			      function(data)
				{
					alert("not found");
				}

	});


}











