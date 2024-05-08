<?php

function findAllLanguages($db) {
    try {
        $testStatement = $db->prepare("select language from languages");
        $testStatement->execute();
        $validOptions = [];
        foreach ($testStatement as $row) {
            $validOptions[] = strip_tags($row['language']);
        }
    } catch (PDOException $e) {
        print('Error : ' . $e->getMessage());
        exit();
    }
    return $validOptions;
}

function findAllLanguagesByClient($db, $clientId) {
    try {
        $testStatement = $db->prepare("select language 
from languages l 
join clients_languages ul on ul.languages_id = l.id
where ul.clients_id = ?");
        $testStatement->execute([$clientId]);
        $pLang = [];
        foreach ($testStatement as $row) {
            $pLang[] = strip_tags($row['language']);
        }
    } catch (PDOException $e) {
        print('Error : ' . $e->getMessage());
        exit();
    }
    return $pLang;
}

function saveLanguages($db, $languages, $id) {
    try {
        $languageQuery = 'select id from languages where language = ?';
        $linkQuery = 'insert into clients_languages (clients_id, languages_id) values (?, ?)';
        $languageStatement = $db->prepare($languageQuery);
        $linkStatement = $db->prepare($linkQuery);
        foreach ($languages as $language) {
            $languageStatement->execute([$language]);
            $languageId = $languageStatement->fetchColumn();
            if (!$languageId) {
                throw new PDOException("Could not find presented language");
            }
            $linkStatement->execute([$id, $languageId]);
        }
    } catch (PDOException $e) {
        print('Error : ' . $e->getMessage());
        exit();
    }
}

function deleteLanguagesByClientId($db, $id) {
    try {
        $deleteLangs = $db->prepare("delete from clients_languages where clients_id = ?");
        $deleteLangs->execute([$id]);
    } catch (PDOException $e) {
        print('Error : ' . $e->getMessage());
        exit();
    }
}

function findCountByLanguage($db) {
    try {
        $stmt = $db->prepare("select l.language as language, count(*) as c from languages l join clients_languages u on u.languages_id = l.id group by language");
        $stmt->execute();
        $statistics = [];
        foreach ($stmt as $row) {
            $statistics[$row['language']] = $row['c'];
        }
    } catch (PDOException $e) {
        print('Error : ' . $e->getMessage());
        exit();
    }
    return $statistics;
}