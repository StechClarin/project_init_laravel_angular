<?php

namespace Guindy\GuindyTester\Contracts;

interface TesterInterface
{
    /**
     * Lance les tests de l'implémentation.
     *
     * @return void
     */
    public function runTests(): void;

    /**
     * Exécute les opérations de nettoyage si nécessaire.
     * Ex: Suppression d'entités créées, réinitialisation d'état, etc.
     *
     * @return void
     */
    public function cleanup(): void;
}
