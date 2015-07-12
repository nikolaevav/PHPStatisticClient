<?php
header('Content-Type: text/html; charset=utf-8');

require_once(__DIR__ . '/client/GitHubClient.php');
include 'config.php';
include 'opendb.php';
include 'function.sql.php';
if(!empty($_POST['repository'])) {
  include 'function.load.php';
}
include 'function.paginate.php';
?>
<!DOCTYPE HTML>
<html>
  <head>
    <title>HTML5 UP</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=1000" />
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/assets/css/bootstrap-datepicker3.min.css">
    <link rel="stylesheet" href="/assets/css/main.css" />
  </head>
  <body>
    <nav class="navbar navbar-default">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="#">
            Тестовое задание: Веб-приложение со статистикой репозитория Git
          </a>
        </div>
      </div>
    </nav>
    <div class="container">
      <div class="alert alert-danger" role="alert">Просьба не злоуботреблять большим количеством коммитов в репозитории, GitHub блокирует частые запросы с одного IP</div>
      <div class="page-header">
        <h3>Форма ввода: <small>Ссылка только на репозиторий GitHub</small></h3>
      </div>
      <div class="inner-form">
        <form accept-charset="UTF-8" action="/" class="simple_form load" data-remote="true" method="post" novalidate="novalidate">
          <div style="display:none"><input name="utf8" type="hidden" value="✓"></div>
          <div class="row">
            <div class="col-md-8">
              <div class="form-group string required">
                <label class="string required control-label" for="url_repository"><abbr title="required">*</abbr> URL репозитория:</label>
                <input class="string required form-control" id="url_repository" maxlength="255" name="repository" placeholder="" size="255" type="text"></div>
              </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group string">
                <label class="tel control-label" for="date_start">Дата начала коммитов (не обязательно):</label>
                <input class="string form-control form-control datapicker" id="date_start" maxlength="255" name="date_start" placeholder="YYYY-MM-DD" size="255" type="text" data-provide="datepicker"></div>
            </div>
            <div class="col-md-4">
              <div class="form-group string">
                <label class="text required control-label" for="date_end">Дата конца коммитов (не обязательно):</label>
                <input class="string form-control form-control datapicker" id="date_end" maxlength="255" name="date_end" placeholder="YYYY-MM-DD" size="255" type="text" data-provide="datepicker"></div>
            </div>
            <div class="col-md-3">
            <input class="btn btn-success btn-search-submit" name="commit" type="submit" value="Загрузить">
            </div>
          </div>
        </form>
      </div>
      <div class="page-header">
        <h3>Результат загрузки:</h3>
      </div>
      <table class="table table-striped j-table-sorted">
        <thead>
          <tr>
            <th data-sort="string">Название файла</th>
            <th data-sort="int">Общее кол-во коммитов</th>
            <th data-sort="string">Список авторов</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $rows = statistic_read($page);
            while ($row = mysql_fetch_assoc($rows)) {
              echo "<tr><td>" . $row['filename'] . "</td><td>" . $row['count'] . "</td><td class='author-list'>";

              $authors = commiter_count($row['key']);
              while ($author = mysql_fetch_assoc($authors)) {
                echo "<li>". $author['authorname'] ." <span class='badge'>". $author['count'] . "</span></li>";
              }

              echo"</td></tr>";
            }
          ?>
        </tbody>
      </table>

    <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="/assets/js/bootstrap-datepicker.min.js"></script>
    <script src="/assets/js/stupidtable.js"></script>
    <script src="/assets/js/main.js"></script>
    <script>
      //<![CDATA[
      $('.datapicker').datepicker({
        format: "yyyy-mm-dd",
        language: 'ru'
      });
      $(".j-table-sorted").stupidtable();
      //]]>
    </script>
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function (d, w, c) {
            (w[c] = w[c] || []).push(function() {
                try {
                    w.yaCounter31370898 = new Ya.Metrika({
                        id:31370898,
                        clickmap:true,
                        trackLinks:true,
                        accurateTrackBounce:true,
                        webvisor:true,
                        trackHash:true,
                        ut:"noindex"
                    });
                } catch(e) { }
            });

            var n = d.getElementsByTagName("script")[0],
                s = d.createElement("script"),
                f = function () { n.parentNode.insertBefore(s, n); };
            s.type = "text/javascript";
            s.async = true;
            s.src = "https://mc.yandex.ru/metrika/watch.js";

            if (w.opera == "[object Opera]") {
                d.addEventListener("DOMContentLoaded", f, false);
            } else { f(); }
        })(document, window, "yandex_metrika_callbacks");
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/31370898?ut=noindex" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
  </body>
</html>
<?php

include 'closedb.php';
