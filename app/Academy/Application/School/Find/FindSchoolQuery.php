<?php

declare(strict_types=1);

namespace App\Academy\Application\School\Find;

// QUERY: solo lee, no modifica estado
// Por eso es Query y no Command
final class FindSchoolQuery
{
    public function __construct(
        public readonly string $id,
    ) {}
}
