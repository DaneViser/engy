$(document).ready(function(){



    if (document.getElementById("apex_mixed1")) {


        $.post("ajax.php?f=trafficChart", function (response) {
            var respArray = response.split(" ");
            var yourTraffic = respArray[1].split(",").map(function (x) { return parseInt(x); })
            var trafficGoal = respArray[0].split(",").map(function (x) { return parseInt(x); })

            console.log(yourTraffic, trafficGoal)

            options.series = [{
                name: 'Your traffic',
                type: 'column',
                data: yourTraffic
            }, {
                name: 'Manager Expetation',
                type: 'area',
                data: trafficGoal
            },]

            var chart = new ApexCharts(
                document.querySelector("#apex_mixed1"),
                options
            );

            chart.render();
        })


    }
    if(document.getElementById("table_body")){
        fillDataTable();
    }
    if(document.getElementById("table_body_visit")){
        var user = document.getElementById("visit_user").innerHTML;
        fillDataTableVisit(user);
    }
    if(document.getElementById("table_archive_body_visit")){
        var user = document.getElementById("visit_user").innerHTML;
        fillArchiveTableVisit(user);
    }
    if(document.getElementById("archive_table")){
        fillArchiveTable();
    }
    if(document.getElementById("traffic_goal")){
        fillTrafficGoal();
    }
    if(document.getElementById("users_table")){
        fillUsersTable();
    }
    if(document.getElementById("reports_table")){
        fillReportsTable();
    }
    if(document.getElementById("message_div_global")){
        fillMessages(0);
    }
    if(document.getElementById("message_div_private")){
        fillMessages(1);
    }

    $("#login").click(function(){
        let korIme = $("#form2Example11").val();
        let pass = $("#form2Example22").val();

        console.log(korIme, pass);
        if(korIme == "" || pass == ""){
            $("#odgPrijava").html('<div class="alert alert-danger" role="alert">You need to enter username and password</div>');
            return false;
        }
        $.post("ajax.php?f=prijava",{korIme:korIme, pass:pass}, function(response){
            console.log(response)
            if(response.startsWith("prijavljen.php")){
                window.location.assign("prijavljen.php");

            }
            else{
                $("#odgPrijava").html(response);
            }
        })

    });

    //sendPrivateMessage
    $("#sendPrivateMessage").click(function(){
        let message_text = $("#privateMessageText").val();
        let to_user = $("#clickedUserId").html();
        console.log(message_text, to_user);
        if(message_text == ""){
            //$("#odgPrijava").html('<div class="alert alert-danger" role="alert">You need to enter username and password</div>');
            return false;
        }
        $("#privateMessageText").val("");
        $.post("ajax.php?f=sendPrivateMessage",{message_text:message_text, to_user:to_user}, function(response){
            console.log(response)
            // if(response.startsWith("prijavljen.php")){
                // }
                // else{
                    //     $("#odgPrijava").html(response);
                    // }
        })

    });

    $("#checkGlobalMessages").click(function(){
        console.log("SLANJE USPELO");
        fillGlobalMessagesModal();
    });
    $("#sendGlobalMessage").click(function(){
        let message_text = $("#globalMessageText").val();
        console.log(message_text);
        if(message_text == ""){
            //$("#odgPrijava").html('<div class="alert alert-danger" role="alert">You need to enter username and password</div>');
            return false;
        }
        $("#globalMessageText").val("");
        $.post("ajax.php?f=sendGlobalMessage",{message_text:message_text}, function(response){
            console.log(response)
            // if(response.startsWith("prijavljen.php")){
            // }
            // else{
            //     $("#odgPrijava").html(response);
            // }
        })

    });

    $("#sendReportbtn").click(function(){
        var myContent = tinymce.get("elm1").getContent();
        if(myContent == "") return;
        showAlert2()
        tinymce.activeEditor.setContent("");
        console.log(myContent);
        $.post("ajax.php?f=sendReport",{myContent:myContent}, function(response){
            console.log(response);
        })
    });

    $("#insertRow").click(function(){
        let ins_customer       = $("#ins_customer").html();
        let ins_prod           = $("#ins_prod").html();
        let ins_traff          = $("#ins_traff").html();
        let ins_maincomp       = $("#ins_maincomp").html();
        let ins_dest           = $("#ins_dest").html();
        let ins_looking        = $("#ins_looking").html();
        let ins_pot            = $("#ins_pot").html();
        let ins_act            = $("#ins_act").html();
        let ins_next           = $("#ins_next").html();
        let ins_result         = $("#ins_result").html();
        let ins_datecomm       = $("#ins_datecomm").html();


        console.log(ins_customer,
                    ins_prod    ,
                    ins_traff   ,
                    ins_maincomp,
                    ins_dest    ,
                    ins_looking ,
                    ins_pot     ,
                    ins_act     ,
                    ins_next    ,
                    ins_result  ,
                    ins_datecomm);


            $.post("ajax.php?f=insertRow",
            {
                ins_customer:ins_customer,
                ins_prod    :ins_prod    ,
                ins_traff   :ins_traff   ,
                ins_maincomp:ins_maincomp,
                ins_dest    :ins_dest    ,
                ins_looking :ins_looking ,
                ins_pot     :ins_pot     ,
                ins_act     :ins_act     ,
                ins_next    :ins_next    ,
                ins_result  :ins_result  ,
                ins_datecomm:ins_datecomm
            },

            function(response){
                fillDataTable();
                $("#insertResp").html(response);
            })


            //RESET FIELDS
            $("#ins_customer").html("");
            $("#ins_prod").html("");
            $("#ins_traff").html("");
            $("#ins_maincomp").html("");
            $("#ins_dest").html("");
            $("#ins_looking").html("");
            $("#ins_pot").html("");
            $("#ins_act").html("");
            $("#ins_next").html("");
            $("#ins_result").html("");
            $("#ins_datecomm").html("");

    });

})
function fillTrafficGoal(){
    console.log("JAVA")
    $.post("ajax.php?f=fillTrafficGoal", function(response){
        $("#traffic_goal").html(response);
    })
}
function fillDataTableVisit(id){
    console.log(id);
    $.post("ajax.php?f=fillDataTableVisit",{id:id}, function(response){
        $("#table_body_visit").html(response);
    })
}
function fillArchiveTableVisit(id){
    console.log(id);
    $.post("ajax.php?f=fillArchiveTableVisit",{id:id}, function(response){
        $("#table_archive_body_visit").html(response);
    })
}
function fillDataTable(){
    $.post("ajax.php?f=fillDataTable", function(response){
        $("#table_body").html(response);
    })
}
function fillArchiveTable(){
    console.log("FILL TABLE");
    $.post("ajax.php?f=fillArchiveTable", function(response){
        $("#archive_table").html(response);
    })
}
function fillUsersTable(){
    $.post("ajax.php?f=fillUsersTable", function(response){
        $("#users_table").html(response);
    })
}
function fillReportsTable(){
    $.post("ajax.php?f=fillReportsTable", function(response){
        $("#reports_table").html(response);
    })
}
function fillGlobalMessagesModal(){
    $("#modal_heading").html("Global Messages");
    $.post("ajax.php?f=checkGlobalMessages", function(response){
        $("#globalMessagesForUser").html(response);
    })
}
function fillPrivateMessageModal(id){
    $("#modal_heading").html("Private Messages");
    $.post("ajax.php?f=checkPrivateMessages",{id:id}, function(response){
        $("#globalMessagesForUser").html(response);
    })
}

function fillMessages(type){
    if(type == 0){
        $.post("ajax.php?f=fillMessages",{type:type}, function(response){
            $("#message_div_global").html(response);
        })
    }
    else{
        $.post("ajax.php?f=fillMessages",{type:type}, function(response){
            $("#message_div_private").html(response);
        })
    }

}
// setInterval(() => {
//     fillMessages(1); fillMessages(0);
// }, 2000);

function deleteRecord(id){
    $.post("ajax.php?f=deleteRecord",{id:id}, function(response){
        $("#insertResp").html(response);
        fillDataTable();
    })
}
function sendToArch(id){


    document.getElementById("archvInfo").style.visibility = "visible";
    setTimeout(() => {
        document.getElementById("archvInfo").style.visibility = "hidden";

    }, 2000);

    document.getElementById("archvInfo").style.visibility = "visible";
    $.post("ajax.php?f=sendToArch",{id:id}, function(response){
        $("#insertResp").html(response);
        fillDataTable();
    })
}

function returnFromArchive(id){
    $.post("ajax.php?f=returnFromArchive",{id:id}, function(response){
        $("#insertResp").html(response);
        fillArchiveTable();
    })
}