<?php
include 'header.php';
?>

<div class="content">
    <div class="container">
        <div class="row js-itemsContainer">

            <?php foreach($data['tasks'] as $task):?>

            <div class="col-12">
                <div class="task">
                    <div class="row">
                        <div class="col-6">
                            Имя пользователя: <?=$task['name']?> <br />
                            E-mail: <?=$task['email']?> <br />
                        </div>
                        <div class="col-6 task__status">
                            <?php if(!empty($task['status'])):?>
                                <span class="badge badge-pill badge-success">Задача выполнена исполнителем</span>
                            <?php endif;?>
                            <?php if(!empty($task['edited'])):?>
                                <br />
                                <span class="badge badge-secondary">Отредактировано администратором</span>
                            <?php endif;?>
                        </div>
                        <div class="col-12">
                            <div class="task__text">
                                <?php if(!empty($data['isAdmin'])): ?>
                                <form class="js-taskEdit" action="/tasks/update/<?=$task['id']?>/" method="post">
                                    <input type="hidden" name="id" value="<?=$task['id']?>">
                                    <label>
                                        <input type="checkbox" name="status" <?php if(!empty($task['status'])){ echo 'checked'; }?> >
                                        Задача выполнена исполнителем
                                    </label>
                                    <textarea class="form-control" name="text" rows="8" placeholder="Введите текст задачи"><?=$task['text']?></textarea>
                                    <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#editModal" data-id="<?=$task['id']?>">
                                      Сохранить задачу
                                    </button>
                                    <div class="response"></div>
                                </form>

                                <?php else:?>
                                    <?=$task['text']?>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>

        </div>
        <div class="row">
            <div class="col-12">
                <div class="paging text_center js-paging">
                    <button class="paging__item active">1</button>
                    <button class="paging__item">2</button>
                    <button class="paging__item">3</button>
                    <button class="paging__item">4</button>
                    <button class="paging__item">5</button>
                </div>
            </div>
        </div>

    </div>
</div>


<?php
include 'footer.php';
?>
