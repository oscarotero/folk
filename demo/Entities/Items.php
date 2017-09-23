<?php

namespace Demo\Entities;

use Psr\Http\Message\UploadedFileInterface;

use Folk\Entities\Json;
use Folk\Formats\Group;
use Folk\Formats\FormatFactory;

class Items extends Json
{
    public $icon = 'file';
    public $title = 'Items';
    public $description = 'Random items';

    protected function getBasePath(): string
    {
        return __DIR__.'/json';
    }

    public function create(array $data)
    {
        if ($data['imageupload'] instanceof UploadedFileInterface) {
            $file = $data['imageupload'];
            $file->moveTo(__DIR__.'/img/'.$file->getClientFilename());
            $data['imageupload'] = '/'.$file->getClientFilename();
        }

        return parent::create($data);
    }

    public function getScheme(FormatFactory $builder): Group
    {
        return $builder->group([
            'text' => $builder->text()->label('Title'),
            'checkbox' => $builder->checkbox()->label('Checkbox'),

            'choose' => $builder->choose([
                1 => $builder->radio()->label('Radio 1'),
                2 => $builder->radio()->label('Radio 2'),
            ])->label('Choose'),

            'code' => $builder->code()->label('Code'),

            'collection' => $builder->collection([
                'text' => $builder->text()->label('Text'),
                'textarea' => $builder->textarea()->label('Textarea'),
            ])->label('Collection'),

            'collectionMultiple' => $builder->collectionMultiple([
                'text' => [
                    'text' => $builder->text()->label('Text'),
                    'textarea' => $builder->textarea()->label('Textarea'),
                ],
                'image' => [
                    'text' => $builder->imageUpload()->label('Image'),
                ],
            ])->label('Collection multiple'),

            'color' => $builder->color()->label('Color'),

            'date' => $builder->date()->label('Date'),

            'datetime' => $builder->datetime()->label('Datetime'),

            'datetimeLocal' => $builder->datetimeLocal()->label('Datetime local'),

            'email' => $builder->email()->label('Email'),

            'fileupload' => $builder->fileUpload()->label('File upload'),

            'html' => $builder->html()->label('Html'),

            'imageupload' => $builder->imageUpload()
                ->data('config', [
                    'thumb' => 'Entities/img'
                ])
                ->label('Image upload'),

            'info' => $builder->info()->label('Info'),

            'loader' => $builder->loader([
                'field' => $builder->url()->label('Url'),
                'loader' => $builder->text()->label('Text'),
                ])->label('Loader'),

            'month' => $builder->month()->label('Month'),

            'number' => $builder->number()->label('Number'),

            'password' => $builder->password()->label('Password'),

            'range' => $builder->range()->label('Range'),

            'select' => $builder->select([
                1 => 'One',
                2 => 'Two',
                ])->label('Select'),

            'table' => $builder->table()->label('Table'),

            'tel' => $builder->tel()->label('Tel'),

            'time' => $builder->time()->label('Time'),

            'url' => $builder->url()->label('Url'),

            'week' => $builder->week()->label('Week'),
        ]);
    }
}
