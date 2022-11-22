
    // Prevent Reload after submit
    $("form").submit(function(e){
        e.preventDefault(e);
        formSubmit();
    });


    /* When type in search bar */
    $('#keyword').on('keyup',function(e){
        $('#keyword').removeClass('is-invalid');
        /* if press enter key*/
        if(e.which === 13) {
            search()
        }
    })

    // Search keyword function
    function search(){
        var keyword = $('#keyword').val();
        if(keyword===''){
            $('#keyword').addClass('is-invalid');
        }else{
            $('#keyword').removeClass('is-invalid');
            var data = {keyword};
            filterRequest(data);
            document.getElementById('filter-form').reset();
        }
    }

    // Any checkbox click event
    $(document).on('click','.filter',function(){
        formSubmit();
    })

    // Form Submit
    function formSubmit(){
        loader();
        var data = $("form").serializeArray();
        filterRequest(data);
    }


    // Request to server for filtering
    function filterRequest(data){
        $.post("/search",data, function(data, status){
            if(status=='success'){
                dataView(data);
            }
        });
    }
    // clear all button event
    $('.clearBtn').click(function(){
        clearData();
        $('#keyword').val("");
    })
    // Data display on view
    function dataView(data){
        var html = '';
        if(data.length > 0){
            $('.total_items').html(`${data.length} items found.`)
            data.forEach(function(item,ind){
                html += `<tr> <td>${item.keyword}</td> <td>${item.user.name}</td> <td>${dateFormat(item.created_at)}</td> </tr>`;
            })
            $('.result-table tbody').html(html);

        }else{
            clearData()
        }
    }

    function clearData(){
        $('.total_items').html('');

        $('.result-table tbody').html(`<tr> <td colspan="3" class="text-center">No Items Found!</td></tr>`);
    }

    function loader(){
        $('.total_items').html('<i class="fa fa-refresh fa-spin"></i>');
    }

    // Date simple format
    function dateFormat(dateObject) {
        var d = new Date(dateObject);
        var day = d.getDate();
        var month = d.getMonth() + 1;
        var year = d.getFullYear();
        if (day < 10) {
            day = "0" + day;
        }
        if (month < 10) {
            month = "0" + month;
        }
        var date = day + "-" + month + "-" + year;

        return date;
    }
