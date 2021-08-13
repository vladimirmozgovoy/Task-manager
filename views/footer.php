<!-- createTask -->
<div class="modal fade" id="createTask" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Создание  задачи </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="js-taskCreateForm" action="index.html" method="post">
          <div class="modal-body">
              <input class="form-control" type="text" name="name" placeholder="Имя пользователя" value="">
              <input class="form-control" type="text" name="email" placeholder="Email" value="">
              <textarea class="form-control" name="text" rows="8" placeholder="Введите текст задачи"></textarea>

              <div class="response-errors">

              </div>

              <div class="response-success">

              </div>

          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-primary" data-dismiss="modal">Закрыть</button>
              <button type="submit" class="btn btn-primary">Создать задачу</button>
          </div>
      </form>
    </div>
  </div>
</div>


<!-- login -->
<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Авторизация</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="js-authForm" action="/auth/login" method="post">
          <div class="modal-body">
              <input class="form-control" type="text" name="login" placeholder="Имя пользователя" value="">
              <input class="form-control" type="password" name="password" placeholder="Пароль" value="">

              <div class="response-errors">

              </div>

              <div class="response-success">

              </div>

          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-primary" data-dismiss="modal">Закрыть</button>
              <button type="submit" class="btn btn-primary">Войти</button>
          </div>
      </form>
    </div>
  </div>
</div>


<div class="lastPage hidden" data-lastpage="<?= $data['lastPage'] ?>">

</div>
<script src="./js/jquery.min.js"></script>
<script src="./js/common.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>
