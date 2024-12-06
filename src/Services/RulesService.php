<?php

namespace Flute\Modules\Rules\src\Services;

use Flute\Modules\Rules\database\Entities\RulesItemBlock;
use Flute\Modules\Rules\database\Entities\RulesSettings;
use Flute\Modules\Rules\database\Entities\RulesItem;
use Flute\Core\Page\PageEditorParser;
use Nette\Utils\Json;
use Nette\Utils\JsonException;

class RulesService
{
    public function find($id)
    {
        $rulesItem = rep(RulesItem::class)
            ->select()
            ->load('blocks')
            ->where(['id' => $id])
            ->fetchOne();

        if (!$rulesItem) {
            throw new \Exception(__('rules.not_found'));
        }

        return $rulesItem;
    }

    public function parseBlocks(RulesItem $rulesItem)
    {
        try {
            /** @var PageEditorParser $parser */
            $parser = app(PageEditorParser::class);

            $blocks = Json::decode($rulesItem->blocks->json ?? '[]', Json::FORCE_ARRAY);

            return $parser->parse($blocks);
        } catch (JsonException $e) {
            return null;
        }
    }

    public function update(int $id, string $rule, $json)
    {
        $rulesItem = $this->find($id);

        $rulesItem->rule = $rule;

        $block = new RulesItemBlock();
        $block->json = $json;
        $block->rulesItem = $rulesItem;

        $rulesItem->blocks = $block;

        transaction($rulesItem)->run();
    }

    public function saveSetting(string $key, string $value): void
    {
        $setting = rep(RulesSettings::class)->findOne(['key' => $key]);

        if (!$setting) {
            $setting = new RulesSettings();
            $setting->key = $key;
        }

        $setting->value = $value;

        transaction($setting)->run();
    }

    public function getSetting(string $key): ?string
    {
        $setting = rep(RulesSettings::class)->findOne(['key' => $key]);
        return $setting ? $setting->value : null;
    }
}
