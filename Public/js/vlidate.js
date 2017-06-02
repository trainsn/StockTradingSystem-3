 function validate(){
            if(document.forms["myForm"].username.value==""){
                document.getElementById("nameInfo").innerHTML="请填写用户名！"
                document.forms["myForm"].username.focus();
                return false;
            }
            if(!checkUserName()) return false;
            if(document.forms["myForm"].password.value==""){
                document.getElementById("passwordInfo").innerHTML="请填写密码！"
                document.forms["myForm"].password.focus();
                return false;
            }
            if(!checkPassword()) return false;
            if(document.forms["myForm"].password.value!==myForm.repassword.value){
                document.getElementById("repasswordInfo").innerHTML="两次输入的密码不一致！"
                document.forms["myForm"].repassword.focus();
                return false;
            }
            if(document.forms["myForm"].email.value==""){
                document.getElementById("emailInfo").innerHTML="请填写邮箱！"
                document.forms["myForm"].email.focus();
                return false;
            }
            if(document.forms["myForm"].phone_number.value==""){
              document.getElementById("phoneInfo").innerHTML="请填写手机号！"
              document.forms["myForm"].phone_number.focus();
              return false;
            }
            
            if(!checkemail()) return false;
            if(!checkphone()) return false;
          }

          function checkUserName(){
            var name=document.forms["myForm"].username.value.trim();
            var nameRegex=/^\w{6,20}$/;
            if(!nameRegex.test(name)){
                document.getElementById("nameInfo").innerHTML="用户名由6到20个字符(支持字母、数字、下划线)组成";
                return false;
            }else{
                document.getElementById("nameInfo").innerHTML="";
                return true; 
            }
          }

          //验证密码（长度在8个字符到16个字符）
          function checkPassword(){
            var password=document.forms["myForm"].password.value.trim();
            //var password=$("#password").value;
            $("#passwordInfo").innerHTML="";
            //密码长度在8个字符到16个字符，由字母、数字和".""-""_""@""#""$"组成
            //var passwordRegex=/^[0-9A-Za-z.\-\_\@\#\$]{8,16}$/;
            //密码长度在8个字符到16个字符，由字母、数字和"_"组成
            var passwordRegex=/^[0-9A-Za-z_]\w{7,15}$/;
            if(!passwordRegex.test(password)){
                document.getElementById("passwordInfo").innerHTML="密码由8到16个字符(支持字母、数字、下划线)组成";
                return false;
            }else{
                document.getElementById("passwordInfo").innerHTML="";
                return true;
            }
          }

        //验证校验密码（和上面密码必须一致）
        function recheckqwd(){
            var repassword=document.forms["myForm"].repassword.value.trim();
            var password=document.forms["myForm"].password.value.trim();
            //校验密码和上面密码必须一致
            if(repassword!==password){
                document.getElementById("repasswordInfo").innerHTML="两次输入的密码不一致";
                return false;
            }else if(repassword==password){
                document.getElementById("repasswordInfo").innerHTML="";
                return true;
            }
        }

        function checkemail(){
          var x=document.forms["myForm"].email.value;
          var atpos=x.indexOf("@");
          var dotpos=x.lastIndexOf(".");
          if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length){
              document.getElementById("emailInfo").innerHTML="不是一个有效的 e-mail 地址";
              return false;
          }
          else{
                document.getElementById("emailInfo").innerHTML="";
                return true;
          }
        }

        function checkphone(){
          var tel=document.forms["myForm"].phone_number.value;
          if(!/^1[3|4|5|7|8][0-9]{9}$/.test(tel)){
            document.getElementById("phoneInfo").innerHTML="请填写正确的手机号码！";
            return false;
          }
          else{
            document.getElementById("phoneInfo").innerHTML="";
            return true;
          }
        }