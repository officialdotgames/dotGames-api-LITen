
$(function() {
  $("#submitButton").on("click", function(event){
    //$form.find('.submit').prop('disabled', true).html('Please wait...');
    event.preventDefault();

    $('#submitButton').prop('disabled', true);


    var email = $("#email").val();
    var password = $("#password").val();

    var send = true;

    if(email == "") {
        send = false;
    }

    if(password == "") {
        send = false;
    }

    if(send){

      var data = {
        state: getParameterByName("state"),
        redirect_uri: getParameterByName("redirect_uri"),
        scope: getParameterByName("scope"),
        client_id: getParameterByName("client_id"),
        email: email,
        password: password
      }

      console.log(data);

      $.ajax({
        type: "POST",
        url: "/v1/api/login",
        data: data,
        success: function(data, status) {
          window.location.replace(data.link);
          //console.log(data.link);
        },
        error: function(xhr, status, error) {
          //$form.find('.auth-errors').text("Incorrect email or password");
          $('#submitButton').prop('enabled', true);
          console.log("you have an error." + error);
        }
      });

    } else {
        //$form.find('.submit').prop('disabled', false).html('Submit');
    }
  })

  function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}
});
