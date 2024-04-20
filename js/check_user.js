function checkUser(user) {
    if (user.value == '') {
        $('#used').html('&nbsp;')
        return
    }

    $.post (
    'checkuser.php',
    { user : user.value },
    function(data) {
        $('#used').html(data)
    })
}
