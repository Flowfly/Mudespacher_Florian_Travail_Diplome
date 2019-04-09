<?php

namespace App\Http\Resources;

use App\Proposition;
use Illuminate\Http\Resources\Json\ResourceCollection;

class QuestionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'label' => $this->label,
            'type' => $this->type,
            'tag' => $this->tag,
            'propositions' => Proposition::collection($this->propositions)
        ];
    }
}
