function encryptByRSA(data,publicKey) {
    var jsencrypt = new JSEncrypt();
    jsencrypt.setPublicKey(publicKey);
    data =jsencrypt.encrypt(data);
    return data;
}



function getPublicKey() {
    $.ajax({
       url:'/user/getPublicKey',
       type:'get',
       success:function (data) {
           localStorage.setItem('publicKey',data);
       },
        error:function (data) {
             alert(data);
        }
    });
}