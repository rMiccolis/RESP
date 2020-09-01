<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(icd9CodesStrum::class);
        $this->call(icd9EsamStrumCodici::class);
        $this->call(icd9GrupDiagCodici::class);
        $this->call(icd9BlocDiagCodici::class);
        $this->call(icd9CategDiagCodici::class);
        $this->call(icd9DiagCodici::class);
        $this->call(TypesUsersTableSeeder::class);
        $this->call(StateSeeder::class);
        
        //Tabelle con dati statici
        $this->call(PatientsMarriageTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(DrugsCategoriesTableSeeder::class);
        $this->call(DrugsTableSeeder::class);
        $this->call(DrugsVSTableSeeder::class);
        $this->call(LevelConfTableSeeder::class);
        $this->call(LoincTableSeeder::class);
        $this->call(LoincAnswerListTableSeeder::class);
        $this->call(LoincSlabValuesTableSeeder::class);
        $this->call(ContactsTypesTableSeeder::class);

        $this->call(StatiMatrimonialiTableSeeder::class);
        
        //Tabelle con dati statici (Codifiche FHIR)
        $this->call(MaritalStatusTableSeeder::class);
        $this->call(LanguagesTableSeeder::class);
        $this->call(GenderTableSeeder::class);
        $this->call(ContactRelationshipTableSeeder::class);
        $this->call(QualificationCodeTableSeeder::class);
        $this->call(OrganizationTypeTableSeeder::class);
        $this->call(ConditionVerificationStatusTableSeeder::class);
        $this->call(ConditionClinicalStatusTableSeeder::class);
        $this->call(ConditionSeverityTableSeeder::class);
        $this->call(MedicationStatusTableSeeder::class);
        $this->call(EncounterParticipantTypeTableSeeder::class);
        $this->call(ProcedureFollowUpTableSeeder::class);
        $this->call(ImmunizationStatusTableSeeder::class);
        $this->call(ImmunizationRouteTableSeeder::class);
        $this->call(TipoContattoTableSeeder::class);
        $this->call(DeviceStatusTableSeeder::class);
        $this->call(AllergyIntolleranceClinicalStatusTableSeeder::class);
        $this->call(AllergyIntolleranceCVerificationStatusTableSeeder::class);
        $this->call(AllergyIntolleranceTypeTableSeeder::class);
        $this->call(AllergyIntolleranceCategoryTableSeeder::class);
        $this->call(AllergyIntolleranceCriticalityTableSeeder::class);
        $this->call(AllergyIntolleranceReactionSeverityTableSeeder::class);
        $this->call(ConditionCodeTableSeeder::class);
        $this->call(FamilyMemberHistoryConditionOutcomeTableSeeder::class);
        $this->call(FamilyMemberHistoryStatusTableSeeder::class);
        $this->call(ConditionBodySiteTableSeeder::class);
        $this->call(ConditionStageSummaryTableSeeder::class);
        $this->call(ConditionEvidenceCodeTableSeeder::class);
        $this->call(AllergyIntolleranceCodeTableSeeder::class);
        $this->call(AllergyIntolleranceReactionExposureRouteTableSeeder::class);
        $this->call(AllergyIntolleranceReactionManifestationTableSeeder::class);
        $this->call(AllergyIntolleranceReactionSubstanceTableSeeder::class);
        $this->call(DeviceTypeTableSeeder::class);
        $this->call(EncounterReasonTableSeeder::class);
        $this->call(EncounterStatusTableSeeder::class);
        $this->call(EncounterClassTableSeeder::class);
        $this->call(VacciniTableSeeder::class);
        $this->call(ImmunizationVaccineCodeTableSeeder::class);
        $this->call(MedicationCodeTableSeeder::class);
        $this->call(MedicationFormTableSeeder::class);
        $this->call(ProcedureBodySiteTableSeeder::class);
        $this->call(ProcedureCodeTableSeeder::class);
        $this->call(ProcedureComplicationTableSeeder::class);
        $this->call(ProcedureNotDoneReasonTableSeeder::class);
        $this->call(ProcedureReasonCodeTableSeeder::class);
        $this->call(RelatedPersonRelationshipTypeTableSeeder::class);
        $this->call(ObservationStatusTableSeeder::class);
        $this->call(ObservationCategoryTableSeeder::class);
        $this->call(ObservationCodeTableSeeder::class);
        $this->call(ObservationInterpretationTableSeeder::class);
        $this->call(ProviderRoleTableSeeder::class);
        //Fine Codifiche FHIR
        //Fine tabelle dati statici
        
        
        $this->call(UsersTableSeeder::class);
        $this->call(CppUsers::class); 
        $this->call(PatientsTableSeeder::class);

        $this->call(PatientContactTableSeeder::class);
        
        $this->call(TownTableSeeder::class);
        $this->call(ContattoTableSeeder::class);
        

        $this->call(AnamnesiPtSeeder::class);
        $this->call(AnamnesiFmSeeder::class);
        $this->call(AnamnesiPtCodificateSeeder::class); 
        $this->call(CareProviderPeopleTableSeeder::class); 
        $this->call(ContactsTableSeeder::class);
        $this->call(ParametriVitaliTableSeeder::class);
        $this->call(CppPazienteTableSeeder::class);
        $this->call(StatiDiagnosiSeeder::class);
        $this->call(DiagnosiTableSeeder::class);
        $this->call(CppDiagnosiTableSeeder::class);
        $this->call(CentriTipologieTableSeeder::class);
        $this->call(CentriIndaginiTableSeeder::class);
        $this->call(ModalitaContattiTableSeeder::class);
        $this->call(CentriContattiTableSeeder::class);
        $this->call(StatiIndagineSeeder::class);
        $this->call(IndaginiTableSeeder::class);
        $this->call ( CareProviderPeopleTableSeeder::class );
        //$this->call ( ConfidenzialitaSeeder::class );
        $this->call ( ICD9_IDPT_OrganiSeeder::class );
        $this->call ( ICD9_IDPT_Sede_Tipo_InterventoSeeder::class );
        $this->call ( ICD9_IntrventiChirurgici_ProcTerapeuticheSeeder::class );
        $this->call ( SpecializationSeeder::class );
        $this->call ( Visita_SpecializationSeeder::class );
        $this->call ( VisiteTableSeeder::class );
        $this->call ( RolesTableSeeder::class );
        $this->call ( ProcedureCategorySeeder::class );
        $this->call ( ProcedureOutcomeSeeder::class );
        $this->call ( ProcedureStatusSeeder::class );
        $this->call ( ProcTerapSeeder::class );

      //aggiunta classe di seed della tabella molti a molti tra indagini e diangosi
        $this->call ( IndaginiDiagnosiTableSeeder::class );

        $this->call ( CppQualificationTableSeeder::class );

        $this->call ( ParenteTableSeeder::class );
        $this->call ( PazientiFamTableSeeder::class );
        

        $this->call (EmergencyTableSeeder::class);
        

        $this->call ( ImmunizationTableSeeder::class );
        
        $this->call(ImmunizationProviderTableSeeder::class);

        
        $this->call ( Cpp_SpecializationSeeder::class );
        
        $this->call(EncounterParticipantTableSeeder::class);
        $this->call(FamilyMemberHistoryTableSeeder::class);
        $this->call(FamilyMemberHistoryConditionTableSeeder::class);

        //$this->call ( CodificaATCSeeder::class );

        $this->call ( TrattamentiPazienteSeeder::class );
        $this->call ( TrattamentiCareProviderSeeder::class );
        $this->call ( RuoliAmministrativiSeeder::class );
        $this->call ( AmministrativeUserSeeder::class );
        
        $this->call ( AuditLogTest::class );

        $this->call(FormeFarmaceuticheTableSeeder::class);
        $this->call(CodiciATCTableSeeder::class);
        $this->call(FarmaciTableSeeder::class);
        $this->call(TerapieTableSeeder::class);
    }
}
