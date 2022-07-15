<?php
/**
* Plugin Name: Ogtbots
* Plugin URI: https://notsaied.site/
* Description:تستخدم اوجت بوتس للحصول علي المقالات من جميع المواقع داخل الاضافة.
* Version: 1.0
* Author: Saiedoz
* Author URI: http://fb.com/notsaied
**/

const API_URL = ''; // DON'T LEAVE IT EMPTY

    function Homepage(){ //set plugin menu in Dashboard
        add_menu_page(
            'Ogtbots',
            'Ogtbots',
            'edit_posts',
            'ogtbots',
            'html',
            'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IgoJIHZpZXdCb3g9IjAgMCA1MTIgNTEyIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA1MTIgNTEyOyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+CjxnPgoJPGc+CgkJPHBhdGggZD0iTTQ2OS4wNTYsMjk3Ljc3M2gtNDMuMjE3Yy05LjQyNSwwLTE3LjA2Nyw3LjY0MS0xNy4wNjcsMTcuMDY3djYzLjI0M2MwLDExLjI1LTkuMTUyLDIwLjQwMy0yMC40MDMsMjAuNDAzCgkJCXMtMjAuNDAzLTkuMTUyLTIwLjQwMy0yMC40MDNWMjM1LjU1YzE5LjI2Ny0yNy45MiwzMC4wOTItNjEuMTY0LDMwLjA5Mi05My40OUMzOTguMDU4LDYzLjcyOCwzMzQuMzMxLDAsMjU1Ljk5OSwwCgkJCXMtMTQyLjA2LDYzLjcyOC0xNDIuMDYsMTQyLjA2YzAsMzIuMzI3LDEwLjgyNSw2NS41NywzMC4wOTIsOTMuNDl2MTQ0LjIyMmMwLDExLjI1LTkuMTUyLDIwLjQwMy0yMC40MDMsMjAuNDAzCgkJCWMtMTEuMjUsMC0yMC40MDMtOS4xNTItMjAuNDAzLTIwLjQwM3YtNjMuMjQzYzAtOS40MjUtNy42NDEtMTcuMDY3LTE3LjA2Ny0xNy4wNjdINDIuOTQyYy05LjQyNSwwLTE3LjA2Nyw3LjY0MS0xNy4wNjcsMTcuMDY3CgkJCWMwLDkuNDI1LDcuNjQxLDE3LjA2NywxNy4wNjcsMTcuMDY3aDI2LjE1MXY0Ni4xNzdjMCwzMC4wNzEsMjQuNDY1LDU0LjUzNiw1NC41MzYsNTQuNTM2YzMwLjA3MSwwLDU0LjUzNi0yNC40NjQsNTQuNTM2LTU0LjUzNgoJCQlWMjcxLjk4MWM4LjM2Myw2LjUwNSwxNy4xNzgsMTEuOTMzLDI2LjMzMiwxNi4yMTF2MTE2LjE4NWMwLDQwLjUyMi0zMi45NjgsNzMuNDg5LTczLjQ5LDczLjQ4OQoJCQljLTkuNDI1LDAtMTcuMDY3LDcuNjQxLTE3LjA2NywxNy4wNjdTMTIxLjU4MSw1MTIsMTMxLjAwNiw1MTJjNTkuMzQzLDAsMTA3LjYyNC00OC4yNzksMTA3LjYyNC0xMDcuNjIyVjI5OC41NDIKCQkJYzUuNzM0LDAuODUsMTEuNTMzLDEuMjgyLDE3LjM3LDEuMjgyYzUuODM4LDAsMTEuNjM2LTAuNDMyLDE3LjM3LTEuMjgydjEwNS44MzZjMCw1OS4zNDMsNDguMjgsMTA3LjYyMiwxMDcuNjI0LDEwNy42MjIKCQkJYzkuNDI1LDAsMTcuMDY3LTcuNjQxLDE3LjA2Ny0xNy4wNjdzLTcuNjQxLTE3LjA2Ny0xNy4wNjctMTcuMDY3Yy00MC41MjIsMC03My40OS0zMi45NjctNzMuNDktNzMuNDg5VjI4OC4xOTIKCQkJYzkuMTUyLTQuMjc4LDE3Ljk2OC05LjcwNiwyNi4zMzItMTYuMjExdjEwNi4xMDNjMCwzMC4wNzEsMjQuNDY0LDU0LjUzNiw1NC41MzYsNTQuNTM2czU0LjUzNi0yNC40NjUsNTQuNTM2LTU0LjUzNnYtNDYuMTc3CgkJCWgyNi4xNTFjOS40MjUsMCwxNy4wNjctNy42NDEsMTcuMDY3LTE3LjA2N1M0NzguNDgxLDI5Ny43NzMsNDY5LjA1NiwyOTcuNzczeiBNMjU1Ljk5OSwyNjUuNjkKCQkJYy01OS4xNzUsMC0xMDcuOTI2LTYzLjYzMS0xMDcuOTI2LTEyMy42MzFjMC01OS41MSw0OC40MTUtMTA3LjkyNiwxMDcuOTI2LTEwNy45MjZTMzYzLjkyNSw4Mi41NDksMzYzLjkyNSwxNDIuMDYKCQkJQzM2My45MjUsMjAyLjE5OCwzMTUuMDQ4LDI2NS42OSwyNTUuOTk5LDI2NS42OXoiLz4KCTwvZz4KPC9nPgo8Zz4KCTxnPgoJCTxjaXJjbGUgY3g9IjIwOS42NjkiIGN5PSIyMDQuMTc0IiByPSIyMi41NzciLz4KCTwvZz4KPC9nPgo8Zz4KCTxnPgoJCTxjaXJjbGUgY3g9IjMwMy4wMTIiIGN5PSIyMDQuMTc0IiByPSIyMi41NzciLz4KCTwvZz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4=',
            5
         );
    } //end function

add_action('admin_menu','Homepage');

function html(){
    $sites = file_get_contents(plugin_dir_url( __FILE__ ).'/backend/links.txt');
    $site = explode(PHP_EOL,$sites);
    echo '
    <link href="'.plugin_dir_url( __FILE__ ).'frontend/main.css" rel="stylesheet" />
    <div class="page-content">
        <form>
        <h1>اوجت بوتس</h1>
        <p>هنا لوحة التحكم بالاضافة يمكنك اضافة مقالات عن طريق روابطها فقط , اذا واجهتك اي مشكلة لا تتردد بالاتصال بالمطور <a href="https://fb.com/notsaied">سعيدوز.</a></p>
            <div class="mb-6">
                <div>
                <b>عدد اللينكات : </b> <span id="count">0</span>
                </div>
                
                <div class="mb-6 mt-6">
                    <b>المواقع المتاحه لك : </b> <span>'.implode(' - ',$site).'</span>
                </div>
            </div>
            <textarea rows="8" id="urls" placeholder="حط اللينكات هنا."></textarea>
            <textarea style="border:1px solid #36d692;" disabled rows="8" id="success" placeholder="اللينكات التي تم اضافتها."></textarea>
            <textarea style="border:1px solid #d63638;" disabled rows="8" id="failed" placeholder="اللينكات اللي فشل اضافتها."></textarea>
            <button type="button" class="btn mt-6">يلا نبدء ؟</button>
        </form>

        <hr class="mt-6 mb-6" style="width:50%;">


        <div class="alert text-center">
            <p>
                للاشتراك في الخدمة المدفوعه كلمنا من <a href="https://t.me/notsaied">هنا</a>.            
            </p>
        </div>

    </div>

    <script src="'.plugin_dir_url( __FILE__ ).'frontend/jquery.js" type="text/javascript"></script>
    <script>
    var action = "'.plugin_dir_url( __FILE__ ).'backend/post.php",

        btn = $(".btn");

        btn.click(function(){

        var links = $("#urls").val().split("\n");

        
           $.each(links, function(v){

            req(links[v]); // call ajax function

          }); //end loop
      
            alert("تم الانتهاء بنجاح");
            $("#urls").val("");           

        }); //end btn click function



        function req(link){
              $.ajax({
                url:"'.API_URL.'",
                type: "GET",
                data:{
                  "url":link
                },
                success:function(rs){
                    if(rs.result)
                    {
                        $("#success").append(link+"\n");
                    }else
                    {
                        $("#failed").append(link+"\n");
                    }
                },
                error:function(){
                
                    alert("something wrong");
                
                }

            }); //end ajax function

        }//end req function

        $("#urls").keyup(function(){
            var arr = $("#urls").val().split("\n");
            $("#count").text(arr.length);
        });

    </script>
        ';

}

?>

