//response.setHeader("Set-Cookie", "HttpOnly;Secure;SameSite=Strict");

var _isToggled = true;
function toggleSidebar() {
  if (_isToggled) {
    document.getElementById("navpage-nav").style.left = "0px";
    document.getElementById("toggle-btn").innerHTML =
      '<i class="fas fa-arrow-circle-left fa-2x"></i>';
    //document.getElementById("navpage-main").style.left = "285px";
    //document.getElementById("navpage-main-header").style.left = "285px";
    document.getElementById("rotateBars").style.transform = "rotate(90deg)";
    //document.getElementById("navpage-main").style.right = 0;
    _isToggled = false;
  } else {
    document.getElementById("navpage-nav").style.left = "-235px";
    document.getElementById("toggle-btn").innerHTML =
      '<i class="fas fa-arrow-circle-right fa-2x"></i>';
    document.getElementById("nav-icons").style.left = "235px";
    //document.getElementById("navpage-main").style.left = "50px";
    document.getElementById("rotateBars").style.transform = "rotate(0deg)";
    //document.getElementById("navpage-main-header").style.left = "50px";
    //document.getElementById("navpage-main").style.right = 0;
    _isToggled = true;
  }
}

var _isSelected = false;
function selectAll() {
  var items = document.getElementsByName("acs");

  if (!_isSelected) {
    for (var i = 0; i < items.length; i++) {
      if (items[i].type == "checkbox") {
        items[i].checked = true;
      }
    }
    _isSelected = true;
  } else {
    for (var i = 0; i < items.length; i++) {
      if (items[i].type == "checkbox") {
        items[i].checked = false;
      }
      _isSelected = false;
    }
  }
}
var alerted = localStorage.getItem("alerted") || "";
function myAlert() {
  alert("hi");
}

function exchange(id) {
  var ie = document.all && !window.opera ? document.all : 0;
  var frmObj = ie ? ie[id] : document.getElementById(id);
  var toObj = ie ? ie[id + "b"] : document.getElementById(id + "b");
  frmObj.style.display = "none";
  toObj.style.display = "inline";
  toObj.value = frmObj.innerHTML;
}
function exchangeBack(id) {
  var ie = document.all && !window.opera ? document.all : 0;
  var toObj = ie ? ie[id + autoInc] : document.getElementById(id + autoInc);
  var frmObj = ie
    ? ie[id + autoInc + "b"]
    : document.getElementById(id + autoInc + "b");
  frmObj.style.display = "none";
  toObj.style.display = "inline";
  toObj.value = frmObj.innerHTML;
  r;
  toObj.removeAttribute("id");
  frmObj.removeAttribute("id");
}
var autoInc = 0;

var close = document.getElementsByClassName("closebtn");
var i;

// Loop through all close buttons
for (i = 0; i < close.length; i++) {
  // When someone clicks on a close button
  close[i].onclick = function() {
    // Get the parent of <span class="closebtn"> (<div class="alert">)
    var div = this.parentElement;

    // Set the opacity of div to 0 (transparent)
    div.style.opacity = "0";

    // Hide the div after 600ms (the same amount of milliseconds it takes to fade out)
    setTimeout(function() {
      div.style.display = "none";
    }, 600);
  };
}

var from = null;
var start = 0;
var url = "chat.php";

////////////JQUERY/////////////////////////////////////////////////////////

$(document).ready(function() {
  // SHOW HOMEPAGE
  // $(".pageTitle").html("Home");
  // $(".btnControls").hide();
  var $onlineStatus = $(".onlineStatus");
  var $changeStatus = $(".changeStatus");
  var $changeSettings = $(".changeSettings");
  var _addAmount = 0;
load();
  //$(".issues").hide();
  $(".btnControls").hide();
  $(".home").show();
  $("#chat").hide();
  /*
  $(".checkers").change(function() {
    if (this.checked) {
      $(this)
        .closest("tr")
        .remove();
    }
  });
  */
  //

  // sending message
  $("#msgForm").submit(function(e) {
    e.preventDefault();
    $.post({
      url: "chat.php",
      data: {
        message: $("#message").val()
      }
    });
    $("#message").val("");
    return false;
  });




  //loading messages
  function load() {
    $.get(url + "?start=" + start, function(result) {
      if (result.items) {
        var totalMSGS = result.items.length;
        result.items.forEach(item => {
          start = item.id;
          $("#messages").append(renderMessage(item));
          $("#messages").scrollTop($("#messages")[0].scrollHeight);
          $(".comments").attr('title', totalMSGS + " New Message(s)");
          $(".comments").tooltip();
        });
      }
      setTimeout(function(){load();}, 1000);
    });
  }
  //display messages
  function renderMessage(item) {
    //console.log(item);

      if(sessionUser == item.user){
        return (
          '<div class="msg"><p>' +
          item.user +
          "</p>" +
          item.message +
          "<span>" +
          item.created +
          "</span></div>"
        );
      }
        return (
          '<div class="msg2"><p>' +
          item.user +
          "</p>" +
          item.message +
          "<span>" +
          item.created +
          "</span></div>"
        );
      
  }

  var $template = $("#template-tr").html();
  var $myTable = $("#myTable");
  var $tableBody = $("tableBody");

  $("#accession,#mrn,#pName,#pDOB,#pDOS,#doctor,#desc")
    .wrapInner('<span title="sort this column"/>')
    .each(function() {
      var th = $(this),
        thIndex = th.index(),
        inverse = false;

      th.click(function() {
        $myTable
          .find("td")
          .filter(function() {
            return $(this).index() === thIndex;
          })
          .sortElements(
            function(a, b) {
              return $.text([a]) > $.text([b])
                ? inverse
                  ? -1
                  : 1
                : inverse
                ? 1
                : -1;
            },
            function() {
              // parentNode is the element we want to move
              return this.parentNode;
            }
          );

        inverse = !inverse;
      });
    });

  $myTable.delegate("input.edit", "keyup", function() {
    if ($(this).val().length == $(this).attr("maxlength")) {
      $(this)
        .parent()
        .parent()
        .next()
        .find("input")
        .focus();
    }
  });

  $myTable.delegate(".editOrder", "click", function() {
    var $tr = $(this).closest("tr");
    $tr.find("input.accession").val($tr.find("span.accession").html());
    $tr.find("input.mrn").val($tr.find("span.mrn").html());
    $tr.find("input.pName").val($tr.find("span.pName").html());
    $tr.find("input.pDOB").val($tr.find("span.pDOB").html());
    $tr.find("input.pDOS").val($tr.find("span.pDOS").html());
    $tr.find("input.doctor").val($tr.find("span.doctor").html());
    $tr.find("input.desc").val($tr.find("span.desc").html());
    $tr.addClass("edit");
  });

  $myTable.delegate(".cancelOrder", "click", function() {
    if (
      $(this)
        .closest("tr")
        .find("input.edit")
        .each(function() {
          if ($(this).val() == "") {
            $(this)
              .closest("tr")
              .remove();
            _addAmount = 0;
          } else {
            var $tr = $(this).closest("tr");
            $tr.find("span.accession").html($tr.find("input.accession").val());
            $tr.find("span.mrn").html($tr.find("input.mrn").val());
            $tr.find("span.pName").html($tr.find("input.pName").val());
            $tr.find("span.pDOB").html($tr.find("input.pDOB").val());
            $tr.find("span.pDOS").html($tr.find("input.pDOS").val());
            $tr.find("span.doctor").html($tr.find("input.doctor").val());
            $tr.find("span.desc").html($tr.find("input.desc").val());
            $tr.removeClass("edit");
          }
        })
    ) {
    }
    $(this)
      .closest("tr")
      .removeClass("edit");
  });

  var $alertBox = $(".alert");

  $myTable.delegate("input.edit", "keypress", function(event) {
    var keycode = event.keyCode ? event.keyCode : event.which;
    if (keycode == "13") {
      var empty = $(this)
        .parent()
        .parent()
        .find("input")
        .filter(function() {
          return this.value === "";
        });
      if (empty.length) {
        alert("Please fill out all of the fields");
      } else {
        var $tr = $(this).closest("tr");
        var $accession = $tr.find("input.accession").val();
        var $mrn = $tr.find("input.mrn").val();
        var $pName = $tr.find("input.pName").val();
        var $pDOB = $tr.find("input.pDOB").val();
        var $pDOS = $tr.find("input.pDOS").val();
        var $doctor = $tr.find("input.doctor").val();
        var $desc = $tr.find("input.desc").val();
        var $id = $tr.attr("id");
        $tr.find("span.accession").html($accession);
        $tr.find("span.mrn").html($mrn);
        $tr.find("span.pName").html($pName);
        $tr.find("span.pDOB").html($pDOB);
        $tr.find("span.pDOS").html($pDOS);
        $tr.find("span.doctor").html($doctor);
        $tr.find("span.desc").html($desc);
        $.ajax({
          url: "update.php",
          type: "POST",
          cache: false,
          data: {
            id: $id,
            accession: $accession,
            mrn: $mrn,
            pName: $pName,
            pDOB: $pDOB,
            pDOS: $pDOS,
            doctor: $doctor,
            description: $desc
          },
          success: function(dataResult) {
            var dataResults = JSON.parse(dataResult);
            if (dataResults.statusCode == 200) {
              //location.reload();
              $tableBody.load("disc.php");
              $tr.attr("id", dataResults.last_insert_id);
              //$alertMessage("success", dataResults.last_insert_id);
            }
          }
        });
        $tr.removeClass("edit");
        $alertMessage("success", "Save Completed");
        _addAmount = 0;
      }
    }
    event.stopPropagation();
  });
  $myTable.delegate(".saveOrder", "click", function() {
    var empty = $(this)
      .parent()
      .parent()
      .find("input")
      .filter(function() {
        return this.value === "";
      });
    if (empty.length) {
      alert("Please fill out all of the fields");
    } else {
      var $tr = $(this).closest("tr");
      var $accession = $tr.find("input.accession").val();
      var $mrn = $tr.find("input.mrn").val();
      var $pName = $tr.find("input.pName").val();
      var $pDOB = $tr.find("input.pDOB").val();
      var $pDOS = $tr.find("input.pDOS").val();
      var $doctor = $tr.find("input.doctor").val();
      var $desc = $tr.find("input.desc").val();
      var $id = $tr.attr("id");
      $tr.find("span.accession").html($accession);
      $tr.find("span.mrn").html($mrn);
      $tr.find("span.pName").html($pName);
      $tr.find("span.pDOB").html($pDOB);
      $tr.find("span.pDOS").html($pDOS);
      $tr.find("span.doctor").html($doctor);
      $tr.find("span.desc").html($desc);
      $.ajax({
        url: "update.php",
        type: "POST",
        cache: false,
        data: {
          id: $id,
          accession: $accession,
          mrn: $mrn,
          pName: $pName,
          pDOB: $pDOB,
          pDOS: $pDOS,
          doctor: $doctor,
          description: $desc
        },
        success: function(dataResult) {
          var dataResults = JSON.parse(dataResult);
          if (dataResults.statusCode == 200) {
            //location.reload();
            $tableBody.load("disc.php");
            $tr.attr("id", dataResults.last_insert_id);
            //$alertMessage("success", dataResults.last_insert_id);
          }
        }
      });
      $tr.removeClass("edit");
      $alertMessage("success", "Save Completed");
      _addAmount = 0;
    }
  });

  $(".comments").tooltip();
  $(".help").tooltip();
  $(".settings").tooltip();
  $(".avatarStatus").tooltip();
  $(".search-btn").tooltip();

  var $comments = $(".comments");

  function hideNav() {
    if ($(window).width() < 700 && $(window).width() > 530) {
      $(".user_name").toggle();
    }

    if ($(window).width() < 570) {
      $(".avatarStatus").toggle();
      $(".comments").toggle();
      $(".help").toggle();
      $(".settings").toggle();
      $(".onlineStatus").toggle();
      $(".changeStatus").hide();
    }
  }

  $(".search-box").hover(function() {
    hideNav();
  });

  $(".online").on("click", function() {
    $onlineStatus.css("background-color", "greenyellow");
    $changeStatus.slideUp(1000);
  });
  $(".away").on("click", function() {
    $onlineStatus.css("background-color", "orange");
    $changeStatus.slideUp(1000);
  });
  $(".busy").on("click", function() {
    $onlineStatus.css("background-color", "red");
    $changeStatus.slideUp(1000);
  });
  $(".offline").on("click", function() {
    $onlineStatus.css("background-color", "grey");
    $changeStatus.slideUp(1000);
  });

  $(function() {
    $(".avatarStatus").on("click", function() {
      $changeSettings.slideUp(1000);
      $(".changeStatus").slideToggle();
      $(".ui-tooltip").hide();
    });
  });

  $("#home").click(function() {
    $(".pageTitle").html("Home");
    $(".btnControls").hide();
    $(".issues").hide();
    $(".contacts").hide();
    $("#chat").hide();
    $(".home").show();
  });

  $comments.click(function() {
    $(".pageTitle").html("Chat");
    $(".btnControls").hide();
    $(".issues").hide();
    $(".contacts").hide();
    $(".home").hide();
    $("#chat").show();
    $("#messages").scrollTop($("#messages")[0].scrollHeight);
    $("#message").focus();
    load();
  });

  $(".navbar-icon a").click(function() {
    $(".pageTitle").html("Home");
    $(".btnControls").hide();
    $(".issues").hide();
    $(".contacts").hide();
    $("#chat").hide();
    $(".home").show();
  });

  $("#issues").click(function() {
    $(".pageTitle").html("Discrepancies");
    $(".btnControls").show();
    $(".issues").show();
    $(".home").hide();
    $("#chat").hide();
    $(".contacts").hide();
  });

  $("#guides").click(function() {
    $(".pageTitle").html("Guides");
    $(".btnControls").hide();
    $(".issues").hide();
    $(".home").hide();
    $("#chat").hide();
    $(".contacts").hide();
  });
  $("#contacts").click(function() {
    $(".pageTitle").html("Contact Info");
    $(".btnControls").hide();
    $(".issues").hide();
    $(".home").hide();
    $("#chat").hide();
    $(".contacts").css("display", "flex");
  });

  var $alertMessage = function($status, $message) {
    $alertBox
      .removeClass()
      .addClass("alert")
      .addClass($status)
      .show(0)
      .delay(2000)
      .hide(0)
      .find("p")
      .text($message);
  };

  $("#settings").click(function() {
    $changeSettings.slideToggle();
    $changeStatus.slideUp(1000);
    $(".ui-tooltip").hide();
  });

  $(".btnControls").delegate(".add", "click", function() {
    if (_addAmount < 1) {
      $("tbody").append($template);
      $(".accession")
        .mask("a99-9999?9", { placeholder: "" })
        .attr("maxlength", 9)
        .focus();
      $(".pDOB")
        .mask("99/99/9999", { placeholder: "" })
        .attr("maxlength", 10);
      $(".pDOS")
        .mask("99/99/9999", { placeholder: "" })
        .attr("maxlength", 10);
        //$("mainTR").addClass("id",$lastID)
      _addAmount++;
    }
  });

  $(".delete").click(function() {
    var _isAlerted = false;
    $("input:checkbox.checkers").each(function() {
      if (this.checked) {
        $this = $(this).closest("tr");
        $id = $this.attr("id");
        $.ajax({
          url: "delete.php",
          type: "POST",
          cache: false,
          data: {
            id: $id
          },
          success: function(dataResult) {
            var dataResults = JSON.parse(dataResult);
            if (dataResults.statusCode == 200) {
              //location.reload();
            }
          }
        });

        $this.remove();
        _isAlerted = true;
      }
    });
    if (_isAlerted) {
      $alertMessage("error", "Deleted");
      _isAlerted = false;
    }
  });
});
