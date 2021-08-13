var sortArray = {
    'id_asc': {
        'sortField': 'tasks.id',
        'sortDirection': 'DESC'
    },
    'name_asc': {
        'sortField': 'users.name',
        'sortDirection': 'ASC'
    },
    'name_desc': {
        'sortField': 'users.name',
        'sortDirection': 'DESC'
    },
    'email_asc': {
        'sortField': 'users.email',
        'sortDirection': 'ASC'
    },
    'email_desc': {
        'sortField': 'users.email',
        'sortDirection': 'DESC'
    },
    'status_asc': {
        'sortField': 'tasks.status',
        'sortDirection': 'ASC'
    },
    'status_desc': {
        'sortField': 'tasks.status',
        'sortDirection': 'DESC'
    }
};

var maxpage = jQuery('.lastPage').attr('data-lastPage');
var step = 3;

jQuery('.js-sort').on('change',function(){
    var sort = jQuery(this).val();
    var page = jQuery('.paging .active').attr('data-page');
    var data = sortArray[sort];
    data.page = page;

    event.preventDefault();

    $.ajax({
        type: 'get',
        url: '/tasks',
        data : data,
        success: function(data){
            pagination(page, step, maxpage)
            jQuery('.js-paging button[data-page='+page+']').addClass('active')
            tasks = '';

            data.data.tasks.forEach(function callback(task) {

                status = '';
                text = task.text;
                if(task.status == 1){
                    status = '<span class="badge badge-pill badge-success">Задача выполнена исполнителем</span>'
                }
                if(task.edited == 1){
                    status += '<br /><span class="badge badge-secondary">Отредактировано администратором</span>'
                }
                if(data.data.isAdmin == 1){
                    statusCheckbox = '';
                    if(task.status == 1) {
                        statusCheckbox = 'checked';
                    }
                    text = '<form class="js-taskEdit" action="/tasks/update/'+task.id+'/" method="post">\n' +
                        '   <input type="hidden" name="id" value="'+task.id+'">\n' +
                        '   <label>\n' +
                        '       <input type="checkbox" name="status" '+statusCheckbox+' >\n' +
                        '           Задача выполнена исполнителем\n' +
                        '   </label>\n' +
                        '   <textarea class="form-control" name="text" rows="8" placeholder="Введите текст задачи">'+task.text+'</textarea>\n' +
                        '   <button type="submit" class="btn btn-primary" data-id="'+task.id+'">\n' +
                        '       Сохранить задачу\n' +
                        '   </button>\n' +
                        '   <div class="response"></div>\n' +
                        '</form>';
                }

                tasks +='<div class="col-12">\n' +
                    '   <div class="task">\n' +
                    '       <div class="row">\n' +
                    '           <div class="col-6">\n' +
                    '               Имя пользователя: '+task.name+'<br />\n' +
                    '               E-mail: '+task.email+' <br />\n' +
                    '           </div>\n' +
                    '           <div class="col-6 task__status">'+status+'</div>\n' +
                    '               <div class="col-12"><div class="task__text">'+text+'</div></div>\n' +
                    '           </div>\n' +
                    '       </div>\n' +
                    '   </div>';

            });
            jQuery('.js-itemsContainer').html(tasks)
        },
    })

});

jQuery('.js-paging').on('click',function(e){
    var { target } = e
    var { page } = target.dataset

    if(e.target.tagName != 'BUTTON' ){
        return false;
    }

    var sort = jQuery('.js-sort').val();

    var data = sortArray[sort];

    data.page = page;

    event.preventDefault();
    $.ajax({
        type: 'get',
        url: '/tasks',
        data : data,
        success: function(data){
            pagination(page, step, maxpage)
            jQuery('.js-paging button[data-page='+page+']').addClass('active')
            tasks = '';

            data.data.tasks.forEach(function callback(task) {

                status = '';
                text = task.text;
                if(task.status == 1){
                    status = '<span class="badge badge-pill badge-success">Задача выполнена исполнителем</span>'
                }
                if(task.edited == 1){
                    status += '<br /><span class="badge badge-secondary">Отредактировано администратором</span>'
                }
                if(data.data.isAdmin == 1){
                    statusCheckbox = '';
                    if(task.status == 1) {
                        statusCheckbox = 'checked';
                    }
                    text = '<form class="js-taskEdit" action="/tasks/update/'+task.id+'/" method="post">\n' +
                            '   <input type="hidden" name="id" value="'+task.id+'">\n' +
                            '   <label>\n' +
                            '       <input type="checkbox" name="status" '+statusCheckbox+' >\n' +
                            '           Задача выполнена исполнителем\n' +
                            '   </label>\n' +
                            '   <textarea class="form-control" name="text" rows="8" placeholder="Введите текст задачи">'+task.text+'</textarea>\n' +
                            '   <button type="submit" class="btn btn-primary" data-id="'+task.id+'">\n' +
                            '       Сохранить задачу\n' +
                            '   </button>\n' +
                            '   <div class="response"></div>\n' +
                            '</form>';
                }

                tasks +='<div class="col-12">\n' +
                    '   <div class="task">\n' +
                    '       <div class="row">\n' +
                    '           <div class="col-6">\n' +
                    '               Имя пользователя: '+task.name+'<br />\n' +
                    '               E-mail: '+task.email+' <br />\n' +
                    '           </div>\n' +
                    '           <div class="col-6 task__status">'+status+'</div>\n' +
                    '               <div class="col-12"><div class="task__text">'+text+'</div></div>\n' +
                    '           </div>\n' +
                    '       </div>\n' +
                    '   </div>';

            });
            jQuery('.js-itemsContainer').html(tasks)
        },
    })
})

function pagination(b, c, d) { // current , step, max

    var pagination = '';
    var minVal = b - c - 1;
    var maxVal = b;
    var minPagination = '';
    var maxPagination = '';
    var delimeter = ' ... ';
    var last = '<button class="paging__item" data-page="'+d+'"> Последняя страница </button>';
    var start = '<button class="paging__item" data-page="1"> 1 </button>';
    var curpage = '';

    for(i= 0; i < c; i++){
        minVal = minVal + 1;
        maxVal++;
        if(minVal > 1){
            minPagination += '<button class="paging__item" data-page="'+minVal+'"> '+minVal+' </button>';
        }
        if(maxVal < d){
            maxPagination += '<button class="paging__item" data-page="'+maxVal+'"> '+maxVal+' </button>';
        }
    }

    if(+b < +d && +b != 1) {
        curpage = '<button class="paging__item" data-page="'+b+'"> '+b+'</button>';
    }
    pagination += minPagination + curpage + maxPagination;
    if((+b - 5) > 1) {
        start = start + delimeter
    }
    if((+b + 5) <= +d) {
        last = delimeter + last
    }
    pagination = start + pagination + last;
    if(d < 2){
        jQuery('.js-paging').html('');
    } else {
        jQuery('.js-paging').html(pagination);
    }

}

pagination(1, step, maxpage);
jQuery('.js-paging button[data-page=\'1\']').addClass('active');



/* Create task */

jQuery('.js-taskCreateForm').on('submit', (e) => {
    e.preventDefault();
    var form = jQuery('.js-taskCreateForm');

    jQuery.ajax({
        type: 'post',
        url: '/tasks/create',
        data : form.serialize(),
        success: function(data){
            if(!data.success){
                var text = '';
                for (var prop in data.errors) {
                    console.log('data2', data.errors[prop]);
                    text += '<p>'+data.errors[prop]+'</p>';
                }
                jQuery('.response-errors').html(text)
            } else {
                form[0].reset();
                form.find('.js-taskCreateForm button[type=submit]').hide();
                form.find('.response-success').html('<p>Задача успешно создана!</p>');
                window.location.href = '/';
            }
        },
    })
})


/* Update task */

jQuery('.js-itemsContainer textarea').on('change',(e) => {

    var id = jQuery(e.target).parents('.js-taskEdit').find('input[name="id"]').val();

    jQuery.ajax({
        type: 'post',
        url: '/tasks/updateText/'+ id +'/',
        data : {
            'text': jQuery(e.target).val()
        },
        success: function(data){
            if(!data.success){
                var text = data.errors;
                alert(text)
            } else {
                form.find('.response').html('<p class="success">Задача успешно обновлена!</p>');
            }
            window.location.href = '/';
        },
    })
})

jQuery('.js-itemsContainer input[type="checkbox"]').on('change',(e) => {

    var id = jQuery(e.target).parents('.js-taskEdit').find('input[name="id"]').val();
    var status = '';
    if(jQuery(e.target).prop( "checked" )){
        status = 'on';
    }

    jQuery.ajax({
        type: 'post',
        url: '/tasks/updateStatus/'+ id +'/',
        data : {
            'status': status
        },
        success: function(data){
            if(!data.success){
                var text = data.errors;
                alert(text)
            } else {
                form.find('.response').html('<p class="success">Задача успешно обновлена!</p>');
            }
            window.location.href = '/';
        },
    })
})

// jQuery('.js-itemsContainer').on('submit',(e) => {
//     e.preventDefault();
//     form = jQuery(e.target)
//
//     jQuery.ajax({
//         type: 'post',
//         url: form.attr('action'),
//         data : form.serialize(),
//         success: function(data){
//             if(!data.success){
//                 var text = data.errors;
//                 alert(text)
//             } else {
//                 form.find('.response').html('<p class="success">Задача успешно обновлена!</p>');
//             }
//             window.location.href = '/';
//         },
//     })
// })

/* Login */

jQuery('.js-authForm').on('submit', (e) => {
    e.preventDefault();
    var form = jQuery('.js-authForm');

    jQuery.ajax({
        type: 'post',
        url: form.attr('action'),
        data : form.serialize(),
        success: function(data){
            if(!data.success){
                var text = '';
                for (var prop in data.errors) {
                    text += '<p>'+data.errors[prop]+'</p>';
                }
                jQuery('.response-errors').html(text)
            } else {
                form[0].reset();
                form.find('button[type=submit]').hide();
                form.find('.response-success').html('<p>Вы успешно авторизованы</p>');
                window.location.href = '/';
            }
        },
    })
})

/* Logout */

jQuery('.js-logout').on('click', () => {
    jQuery.ajax({
        type: 'post',
        url: '/auth/logout',
        data : {},
        success: function(data){
            window.location.href = '/';
        },
    })
})

