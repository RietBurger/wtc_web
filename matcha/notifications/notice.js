
    $(document).ready(function () {

        var autoselect = document.getElementById('textbox');
        if (autoselect) {
            autoselect.select();
        }

        function load_unseen_notification(view='') {
            $.ajax({
                url: "../notifications/fetch.php",
                method: "POST",
                data: {view: view},
                dataType: "json",
                success: function (data) {
                    $('.dropdown-menu').html(data.notification);

                    if (data.unseen_notification > 0) {
                        $('.count').html(data.unseen_notification);
                    }
                }
            });
        }

        load_unseen_notification();

        $(document).on('click', '.dropdown-toggle', function () {
            $('.count').html('');
            load_unseen_notification('yes');
        });

        function loadLog() {
            $.ajax({
                url: "../chat/get_chat.php",
                cache: false,
                dataType: "json",
                success: function (data) {
                    $('#chatbox').html(data.chat);
                }
            });
        }

        loadLog();

        setInterval(function () {
            load_unseen_notification();
            loadLog();
        }, 2000);
    });
