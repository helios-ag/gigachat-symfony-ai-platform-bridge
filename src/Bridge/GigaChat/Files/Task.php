<?php

namespace FM\AI\Platform\Bridge\GigaChat\Files;

interface Task
{
    public const FILE_LIST = 'list';
    public const FILE_INFO = 'info';
    public const FILE_DELETE = 'delete';
    public const FILE_UPLOAD = 'upload';
}
