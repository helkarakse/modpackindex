<?php

Class APIController extends BaseController
{
    public function getModpacks($version='all', $limit=100, $offset=0)
    {
        if ($version == 'all')
        {
            $raw_modpacks = Modpack::select('name', 'deck', 'website', 'download_link', 'wiki_link', 'description', 'slug',
                'created_at', 'updated_at')->skip($offset)->take($limit)->get();
        }
        else
        {
            $version = preg_replace('/-/', '.', $version);
            $raw_version = MinecraftVersion::where('name', '=', $version)->first();

            if (!$raw_version)
            {
                return json_encode(['error' => 'Not a valid version.']);
            }

            $version_id = $raw_version->id;
            $raw_modpacks = Modpack::select('id', 'name', 'deck', 'website', 'download_link', 'donate_link', 'wiki_link', 'description', 'slug',
                'created_at', 'updated_at')->where('minecraft_version_id', $version_id)->skip($offset)->take($limit)->get();
        }

        if (!$raw_modpacks)
        {
            return json_encode(['error' => 'No results.']);
        }

        return json_encode($raw_modpacks);
    }

    public function getModpack($id)
    {
        $mods = [];

        $raw_modpack = Modpack::find($id);

        if (!$raw_modpack)
        {
            return json_encode(['error' => 'No modpack with that ID found.']);
        }

        $raw_mods = $raw_modpack->mods;

        foreach ($raw_mods as $mod)
        {
            $mods[] = [
                'id' => $mod->id,
                'name' => $mod->name,
                'deck' => $mod->deck,
                'website' => $mod->website,
                'download_link' => $mod->download_link,
                'donate_link' => $mod->website,
                'wiki_link' => $mod->wiki_link,
                'descriptions' => $mod->descriptions,
                'slug' => $mod->slug,
                'created_at' => $mod->created_at,
                'updated_at' => $mod->updated_at,
            ];
        }

        $results = [
            'id' => $raw_modpack->id,
            'name' => $raw_modpack->name,
            'deck' => $raw_modpack->deck,
            'website' => $raw_modpack->website,
            'download_link' => $raw_modpack->download_link,
            'donate_link' => $raw_modpack->website,
            'wiki_link' => $raw_modpack->wiki_link,
            'descriptions' => $raw_modpack->descriptions,
            'mods' => $mods,
            'slug' => $raw_modpack->slug,
            'created_at' => $raw_modpack->created_at,
            'updated_at' => $raw_modpack->updated_at,
        ];

        return json_encode($results);
    }

    public function getMods($version='all', $limit=100, $offset=0)
    {
        $mods = [];

        if ($version == 'all')
        {
            $raw_mods = Mod::select('name', 'deck', 'website', 'download_link', 'wiki_link', 'description', 'slug',
                'created_at', 'updated_at')->skip($offset)->take($limit)->get();
        }
        else
        {
            $version = preg_replace('/-/', '.', $version);
            $raw_version = MinecraftVersion::where('name', '=', $version)->first();

            if (!$raw_version)
            {
                return json_encode(['error' => 'Not a valid version.']);
            }

            $raw_version = MinecraftVersion::where('name', '=', $version)->first();
            $raw_mods = $raw_version->mods;
        }

        if (!$raw_mods)
        {
            return json_encode(['error' => 'No results.']);
        }

        foreach ($raw_mods as $mod)
        {
            $mods[] = [
                'id' => $mod->id,
                'name' => $mod->name,
                'deck' => $mod->deck,
                'website' => $mod->website,
                'download_link' => $mod->download_link,
                'donate_link' => $mod->website,
                'wiki_link' => $mod->wiki_link,
                'descriptions' => $mod->descriptions,
                'slug' => $mod->slug,
                'created_at' => $mod->created_at,
                'updated_at' => $mod->updated_at,
            ];
        }

        return json_encode($mods);
    }

    public function getMod($id)
    {
        $modpacks = [];

        $raw_mod = Mod::find($id);

        if (!$raw_mod)
        {
            return json_encode(['error' => 'No mod with that ID found.']);
        }

        $raw_modpacks = $raw_mod->modpacks;

        foreach ($raw_modpacks as $modpack)
        {
            $modpacks[] = [
                'id' => $modpack->id,
                'name' => $modpack->name,
                'deck' => $modpack->deck,
                'website' => $modpack->website,
                'download_link' => $modpack->download_link,
                'donate_link' => $modpack->website,
                'wiki_link' => $modpack->wiki_link,
                'descriptions' => $modpack->descriptions,
                'slug' => $modpack->slug,
                'created_at' => $modpack->created_at,
                'updated_at' => $modpack->updated_at,
            ];
        }

        $results = [
            'id' => $raw_mod->id,
            'name' => $raw_mod->name,
            'deck' => $raw_mod->deck,
            'website' => $raw_mod->website,
            'download_link' => $raw_mod->download_link,
            'donate_link' => $raw_mod->website,
            'wiki_link' => $raw_mod->wiki_link,
            'descriptions' => $raw_mod->descriptions,
            'modpacks' => $modpacks,
            'slug' => $raw_mod->slug,
            'created_at' => $raw_mod->created_at,
            'updated_at' => $raw_mod->updated_at,
        ];

        return json_encode($results);
    }

    public function getStreams($limit=100, $offset)
    {

    }

    public function getStream($id)
    {

    }

}