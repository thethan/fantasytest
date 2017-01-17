<!DOCTYPE html>
<body>
<script>
    var hash = window.location.hash;

    var query = hash.replace("#", '?');

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if(xhttp.status == 200){ // redirect to home since the user is authenticated.
            window.location.href = '/home';
        };
    };

    xhttp.open("POST", "/api/callback" + query, true);
    xhttp.setRequestHeader('Content-Type', 'application/json');
    xhttp.setRequestHeader('Authorization', 'Bearer {{ Auth::user()->api_token }}');
    xhttp.send(JSON.stringify({
        {{--_token: "{{ csrf_token() }}"--}}
    }));

</script>
</body>
</html>