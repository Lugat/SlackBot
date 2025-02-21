<?php

namespace app\components\slack\routines;

interface RoutineInterface
{
    public function execute(): null|array|string;
}