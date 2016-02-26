# FOLK

The universal CMS

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/oscarotero/folk/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/oscarotero/folk/?branch=master)

This is a framework-agnostic CMS that you can use to edit the content of your site. It works with any kind of websites, no matter if the content is stored in a database, yml files, json, etc.

## Requirements

* PHP >= 5.5
* Composer

## Installation

This package is installable and autoloadable via Composer as [oscarotero/folk](https://packagist.org/packages/oscarotero/folk).

```
composer require oscarotero/folk
```

## Entities

The entities are classes to manage "things". It can be a database table, a file, a directory with files, etc. They must implement the `Folk\Entities\EntityInterface` interface (or extend the `Folk\Entities\AbstractEntity`). Let's see an example of an entity using a database table.

```php
namespace MyEntities;

use Folk\SearchQuery;
use FormManager\Builder;
use Folk\Entities\AbstractEntity;

/**
 * Entity to manage the posts
 */
class Posts extends AbstractEntity
{
    public $title = 'Posts';
    public $description = 'These are the posts of the blog';

    /**
     * List the posts
     *
     * @return array [id => data, ...]
     */
    public function search(SearchQuery $search = null)
    {
        $pdo = $this->admin['pdo'];

        $result = $pdo->query('SELECT * FROM posts');
        $data = [];

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $data[$row['id']] = $row;
        }

        return $data;
    }

    /**
     * Create a new post
     *
     * @return mixed The post id
     */
    public function create(array $data)
    {
        $pdo = $this->admin['pdo'];

        $statement = $pdo->prepare('INSERT INTO posts (title, text) VALUES (:title, :text)');
        $statement->execute([
            ':title' => $data['title'],
            ':text' => $data['text'],
        ]);

        return $pdo->lastInsertId();
    }

    /**
     * Read a post
     *
     * @return array
     */
    public function read($id)
    {
        $pdo = $this->admin['pdo'];

        $statement = $pdo->prepare('SELECT * FROM posts WHERE id = ? LIMIT 1');
        $statement->execute([$id]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Update a post
     */
    public function update($id, array $data)
    {
        $pdo = $this->admin['pdo'];

        $statement = $pdo->prepare('UPDATE posts SET title = :title, text = :text WHERE id = :id LIMIT 1');
        $statement->execute([
            ':title' => $data['title'],
            ':text' => $data['text'],
            ':id' => $data['id'],
        ]);
    }

    /**
     * Delete a post
     */
    public function delete($id)
    {
        $pdo = $this->admin['pdo'];

        $statement = $pdo->prepare('DELETE FROM posts WHERE id = ? LIMIT 1');
        $statement->execute([$id]);
    }

    /**
     * Returns the data scheme used by the posts.
     */
    public function getScheme(Builder $b)
    {
        return $b->group([
            'title' => $b->text()->label('The post title'),
            'text' => $b->html()->label('The body'),
        ]);
    }

    /**
     * Returns the label of a row.
     * (used in autocomplete searches, select, etc)
     */
    public function getLabel($id, array $data)
    {
        return sprintf('%s (%d)', $data['title'], $id);
    }
}
```

## Getting started

Once your entities are created, let's make them to run:

```php
use Folk\Admin;

use Entities\Posts;

//Create a Admin instance passing the admin url:
$admin = new Admin('http://my-site.com/admin');

//Set the pdo instance:
$admin['pdo'] = new PDO('mysql:dbname=database;charset=UTF8') ;

//Add set your entities classes
$admin->setEntities([
    Posts::class
]);

//Run the web
$request = Zend\Diactoros\ServerRequestFactory::fromGlobals();
$emitter = new Zend\Diactoros\Response\SapiEmitter();

$response = $admin($request);
$emitter->emit($response);
```

As you can see, this is a simple example with a mysql table. But the interface is flexible enought to work with any kind of data.

To know how to work with the scheme, visit [form-manager](https://github.com/oscarotero/form-manager/) project.
