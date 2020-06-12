<?php

namespace App\Models\ModelTraits;

trait ScopeUserNameEmailExtraction
{
    use ScopeFuzzyName, ScopeForwardMatchEmail;
}
