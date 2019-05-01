$(document).ready(function () {
    $('#post_comment').on('click', function () {
        //add comment
        $.ajax({
            url: 'ajax.php',
            data: {
                recordId: $('#recordId').val(),
                nameComment: $('#nameComment').val(),
                newComment: $('#newComment').val(),
            },
            dataType: 'json',
            type: 'post',
            success: function(response) {
                // success handling
                if (typeof response.error !== 'undefined') {
                    //err handling
                    alert(response.error);
                } else {
                    //success message
                    $('.block_comment').prepend("" +
                        "<div class=\"commentRecord\">" +
                        "<div class=\"nameComment\">"+$('#nameComment').val()+"</div>" +
                        "<span class=\"comment_date\">" + response.dateBlog +"</span>" +
                        "\<div class=\"textComment\">"+$('#newComment').val()+"</div>" +
                        "</div>");

                    $('#nameComment').val('');
                    $('#newComment').val('');
                }
            },
            error: function(e, message) {
                alert(message);
                // error handling
            }

        });
        return false;
    });

    $('#input_blog').on('click', function () {
        //add post
        $.ajax({
            url: 'ajax.php',
            data: {
                title: $('#title').val(),
                description: $('#description').val(),
                author: $('#author').val()
            },
            dataType: 'json',
            type: 'post',
            success: function(response) {
                // success handling
                if (typeof response.error !== 'undefined') {
                    //err handling
                    alert(response.error);
                } else {
                    alert('Запись успешно добавлена');
                }
            },
            error: function(e, message) {
                alert(message);
                // error handling
            }

        });
        return false;
    });

    $('#exit_btn').on('click', function () {
        //exit from user
        $.ajax({
            url: 'ajax.php',
            data: {
                exit: $('#exit_btn').val()
            },
            dataType: 'json',
            type: 'post',
            success: function(response) {
                // success handling
                if (typeof response.error !== 'undefined') {
                    //err handling
                    alert(response.error);
                } else {
                    console.log("Выход");
                }
            },
            error: function(e, message) {
                alert(message);
                // error handling
            }

        });

    });

    $('#edit_btn').on('click', function () {
        $.ajax({
            url: 'ajax.php',
            data: {
                titleEdit: $('#titleEdit').val(),
                descriptionEdit: $('#descriptionEdit').val(),
                recordId: $('#edit_btn').val()
            },
            dataType: 'json',
            type: 'post',
            success: function(response) {
                // success handling
                if (typeof response.error !== 'undefined') {
                    //err handling
                    alert(response.error);
                } else {
                    $(location).attr('href', 'record.php?recordId='+$('#edit_btn').val());
                }
            },
            error: function(e, message) {
                alert(message);
                // error handling
            }

        });
        return false;
    });
});