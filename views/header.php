<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>My MVC Application</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="/css/style.css">
    </head>
    <body>
        <header class="header">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <select class="custom-select js-sort" name="sort">
                            <option value="id_asc" selected>От новых к старым</option>
                            <option value="name_asc">Сортировка по имени по возрастанию</option>
                            <option value="name_desc">Сортировка по имени по убыванию</option>
                            <option value="email_asc">Сортировка по email по возрастанию</option>
                            <option value="email_desc">Сортировка по email по убыванию</option>
                            <option value="status_asc">Сортировка по статусу по возрастанию</option>
                            <option value="status_desc">Сортировка по статусу по убыванию</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createTask">
                          + Создать задачу
                        </button>
                    </div>
                    <div class="col-md-6 text_right">
                        <?php if(!empty($data['isAdmin'])): ?>
                            <button type="button" class="btn btn-primary js-logout">
                                Выйти
                            </button>
                        <?php else: ?>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#login">
                              Авторизоваться
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </header>
