<?php
$trancateQuery = "TRUNCATE TABLE statistic";
mysql_query($trancateQuery);


$owner = preg_replace('/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})?\/([\/\w \.-]*)?\/([A-Za-z0-9.-]+)\/?([a-z\.]{2,6})*\/?$/', '$4', $_POST['repository']);
$repo = preg_replace('/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})?\/([\/\w \.-]*)?\/([A-Za-z0-9.-]+)\/?([a-z\.]{2,6})*\/?$/', '$5', $_POST['repository']);

$dateStart = $_POST['date_start'];
$dateEnd = $_POST['date_end'];

$client = new GitHubClient();
$client->setPage();
$commits = $client->repos->commits->listCommitsOnRepository($owner, $repo, null, null, null, $dateStart, $dateEnd);

foreach($commits as $commit)
{
    $author = $commit->getAuthor()->getLogin();
    $fullCommit = $client->repos->commits->getSingleCommit($owner, $repo, $commit->getSha());
    foreach($fullCommit->getFiles() as $file)
    {
      statistic_insert($file->getFilename(),$author);
    }
}

header('Location: /');