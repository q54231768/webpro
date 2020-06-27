function getUserMessage()
{
    $.ajax({
        url:'/user/getPersonMessage',
        type:'get',
        headers:{"userToken":localStorage.getItem("userToken")},
        success:function(data) {
            if(data=='未登录'){
                 alert(data);
                window.location.href='login.html';
            }

            var idInput=document.getElementById("id");
            idInput.setAttribute("value",data[0].user_id);
            idInput.readOnly=true;

            var userNameInput=document.getElementById("userName");
            userNameInput.value=data[0].user_name;
            userNameInput.readOnly=true;

            var emailInput=document.getElementById("email");
            emailInput.value=data[0].email;
            emailInput.readOnly=true;

            var createTimeInput=document.getElementById("createTime");
            createTimeInput.value=data[0].create_time;
            createTimeInput.readOnly=true;

            var landingTimesInput=document.getElementById("landingTimes");
            landingTimesInput.value=data[0].landing_times;
            landingTimesInput.readOnly=true;

        },
        error: function(data) {
                alert(data);
            }

    });
}



function loginOut() {
    $.ajax({
        url:'/user/loginOut',
        type:'get',
        success:function(data) {
            window.location.href='login.html';
        },
        error: function(data) {
            alert(data);
        }

    });

}



