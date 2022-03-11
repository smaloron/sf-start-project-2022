<?php

namespace App\Form\DataTransformer;

use App\Entity\Tag;
use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class TagDataTransformer implements DataTransformerInterface
{

    private TagRepository $repository;

    /**
     * @param TagRepository $repository
     */
    public function __construct(TagRepository $repository)
    {
        $this->repository = $repository;
    }


    public function transform(mixed $value)
    {
        $tagArray = $value->toArray();
        $tagArray = array_map(function ($item){
            return $item->getTagName();
        }, $tagArray);
        return implode(', ', $tagArray);
    }

    public function reverseTransform(mixed $value)
    {
        $tagArray = explode(',', $value);
        $tagArray = array_map('trim', $tagArray);
        $tagCollection = new ArrayCollection();

        foreach($tagArray as $tagName){
            $tag = $this->repository->findOneByTagName($tagName);
            if($tag === null){
                $tag = new Tag();
                $tag->setTagName($tagName);
            }

            $tagCollection->add($tag);
        }

        return $tagCollection;
    }
}