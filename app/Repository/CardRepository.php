<?php

namespace App\Repository;
use App\Models\Card;
use App\Interfaces\CardRepositoryInterface;
class CardRepository implements CardRepositoryInterface
{
    public function index(){
        return Card::all();
    }

    public function getById($id){
       return Card::findOrFail($id);
    }

    public function store(array $data){
       return Card::create($data);
    }

    public function update(array $data,$id){
        Card::whereId($id)->update($data);
        return Card::find($id);
    }
    
    public function delete($id){
        Card::destroy($id);
    }
}