<?php
namespace Platform\TodoList\Contants;

use Platform\Base\Supports\Enum;

/**
 * @method static PiorityEnum LOW()
 * @method static PiorityEnum NORMAL()
 * @method static PiorityEnum HIGH()
 */
class PiorityEnum  extends Enum{
    public const LOW = 'LOW';
    public const NORMAL = 'NORMAL';
    public const HIGH = 'HIGH';
}
