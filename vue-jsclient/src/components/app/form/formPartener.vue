<template>
    <validate-window ref="validateWindowRef"
                     :cWidth=500
                     :cHeight=200
                     :cTypeWindows=1
    ></validate-window>

    <validate-window ref="infoWindowRef"
                     :cWidth=300
                     :cHeight=200
                     :cTypeWindows=5
    ></validate-window>

    <validate-window ref="redWindowRef"
                     :cWidth=400
                     :cHeight=200
                     :cTypeWindows=6
    ></validate-window>

    <validate-window ref="refYesNo"
                     :cWidth=300
                     :cHeight=200
                     :cTypeWindows=3
                     @emitYesNoButton = "emitYesNoButton"
    ></validate-window>

    <form-tab :ref = this.REF_FROM_PARTNER>
        <template v-slot:slotTitle>
            <div class="antet">
                <div class="buttons-container">
                    <div class="prime-button last-button">
                        <my-button  :ref=this.REF_BUTTON_ADD_PARTENER @click="this.setFormNew" :heightButton=22 :buttonType=2 title="adauga partener nou" :style="this.ICON_ADD_PARTENER.colorStyle">
                            <font-awesome-icon :icon=this.$constComponent.cfgIconPicture(this.ICON_ADD_PARTENER) size="1x" />
                        </my-button>
                    </div>
                </div>
                <div class="title">{{this.titleForm}}</div>
            </div>
        </template>
        <template v-slot:slotContent>
            <form>
                <table class="ff-form-table">
                    <tr>
                        <td class="label-left bold">
                            <label :for=NUME.id>{{NUME.caption}}</label></td>
                        <td class="control">
                            <input-field
                                :ref = NUME.ref
                                :pConfig = NUME
                            ></input-field></td>
                        <td class="control">
                            <type-partener
                                :pConfig = NOM_TIP_PARTENR
                                :ref = NOM_TIP_PARTENR.ref
                            ></type-partener></td>

                    </tr>

                    <tr>
                        <td class="label-left bold">
                            <label :for=CUI.id>{{CUI.caption}}</label></td>
                        <td class="control">
                            <input-field
                                :ref=CUI.ref
                                :pConfig = CUI
                            ></input-field>
                            <label> cu RO</label>
                            <check-box
                                    :pConfig = RO
                                    :ref= RO.ref
                            ></check-box>
                            <label>&nbsp;&nbsp; fara verificare cod fiscal</label>
                            <check-box
                                :pConfig = SKIP_CHECK_COD
                                :ref= SKIP_CHECK_COD.ref
                            ></check-box>

                            <label class="label-left bold">&nbsp;&nbsp;{{REGCOM.caption}}</label>
                            <input-field
                                :ref = REGCOM.ref
                                :pConfig = REGCOM
                            ></input-field>

                        </td>
                    </tr>
                </table>
            </form>
        </template>


        <template v-slot:slotButton>
            <div class="buttons">
                <my-button @click="this.editPartener" :heightButton=22 :buttonType=0 title="modific date partener">{{this.captionButton}}</my-button>
            </div>
        </template>


    </form-tab>
</template>

<script>
    import AlertWindow from "@/components/base/AlertWindow.vue";
    import FormTab from "@/components/base/FormTab.vue";
    import InputField from "@/components/base/InputField.vue";
    import DropDownSimple from "@/components/base/DropDownSimple.vue";
    import CheckBox from "@/components/base/CheckBox.vue";
    import Button from "@/components/base/Button";

    export default {
        components: {
            'form-tab': FormTab,
            'validate-window': AlertWindow,
            'input-field': InputField,
            'type-partener': DropDownSimple,
            'check-box': CheckBox,
            'my-button': Button
        },
        name: "form-partener",
        created() {
            this.REF_FROM_PARTNER = 'refFormPartner';
            this.REF_BUTTON_ADD_PARTENER = 'refButtonAddPartener';
            this.NUME = this.cfgNume();
            this.NOM_TIP_PARTENR = this.cfgTipPartener();
            this.CUI = this.cfgCui();
            this.RO = this.cfgRO();
            this.SKIP_CHECK_COD = this.cfgSkipCheckCode();
            this.REGCOM = this.cfgRegCom();
            this.MODE = this.$constFROM.MODE_EDIT;
            this.ICON_ADD_PARTENER =  this.$constComponent.ICON_ADD_PERSON("blue");
            this.URL_GETDATA_PARTENER = this.$url.getUrl('partenerGetData');
            this.URL_EDIT_PARTENER = this.$url.getUrl('editPartener');
            this.EMIT_NEW_RECORD = 'emitNewRecord';
        },
        emits: ['emitNewRecord'],
        mounted () {
        },
        methods: {
            getDataPartener: function (idPk) {
                this.post.idPk = idPk;

                this.$refs[this.REF_FROM_PARTNER].showModal(true);
                this.axios
                    .post(this.URL_GETDATA_PARTENER, this.post)
                    .then(response => {
                        this.showModalLoadingDiv = true;
                        this.dataPartener = response.data.records[0];
                    })
                    .catch(error => console.log(error))
                    .finally(() => {
                        this.setModeForm(this.$constFROM.MODE_EDIT);
                        this.$refs[this.REF_FROM_PARTNER].showModal(false);

                    });
            },
            editServerDatePartener: function (){

                if(this.validateForm()){
                    this.$refs.validateWindowRef.show();

                    return false;
                }

                if(!this.toServer.senData){
                    this.$refs.refYesNo.show();
                }

                if(this.toServer.senData){
                    this.toServer.senData = false;
                    this.axios
                        .post(this.URL_EDIT_PARTENER, this.post)
                        .then(response => {
                            if (response.data.succes){
                                if(this.MODE == this.$constFROM.MODE_NEW){
                                    this.post.idPk = response.data.lastId;
                                    this.$emit(this.EMIT_NEW_RECORD, this.post.idPk);
                                }

                                this.getDataPartener(this.post.idPk);
                                this.$refs.infoWindowRef.setCaption("Succes");
                                this.$refs.infoWindowRef.setMessage(this.$appServer.getHtmlSqlFormatMessage(response.data));
                                this.$refs.infoWindowRef.show();
                            }
                            else {
                                this.$refs.validateWindowRef.setCaption("Datele nu pot fi inregistrate");
                                this.$refs.validateWindowRef.setMessage(this.$appServer.getHtmlSqlFormatMessage(response.data));
                                this.$refs.validateWindowRef.show();
                            }

                        })
                        .catch(error => console.log(error))
                        .finally(() => {
                        });
                }
            },
            validateForm: function () {
                let returnMessage = false;

                this.form.message = [];
                this.$check.validateForm(this.$refs);

                if( this.form.message.length>0 ){
                    this.$refs.validateWindowRef.setCaption("Datele nu pot fi inregistrate");
                    this.$refs.validateWindowRef.setMessage(this.$app.getHtmlFormatMessage(this.form.message));
                    returnMessage = true;
                }
                return returnMessage;
            },
            setModeForm: function (mode){
                this.MODE = mode;
                if(this.MODE == this.$constFROM.MODE_EDIT){
                    this.$refs[this.REF_BUTTON_ADD_PARTENER].disable(false);
                    this.captionButton = "Modific datele";
                    // confirm windows
                    this.$refs.refYesNo.setCaption("Editez");
                    this.$refs.refYesNo.setMessage("Modific datele?");

                    this.setPostAction(this.$constComponent.SQL_UPDATE);
                    this.fillForm();
                    console.log('transform formul in modul EDIT !!!!');
                }

                if(this.MODE == this.$constFROM.MODE_NEW){
                    this.captionButton = "Adaug partener";
                    this.setPostAction(this.$constComponent.SQL_INSERT);
                    this.resetfillForm();
                    console.log('transform formul in NEW !!!!');
                }

            },
            setFormNew: function (){
                this.$refs[this.REF_BUTTON_ADD_PARTENER].disable(true);
                this.setModeForm(this.$constFROM.MODE_NEW);
            },
            editPartener: function () {
                this.editServerDatePartener();
            },
            resetfillForm: function () {
                this.titleForm = "...";
                this.$refs[this.NUME.ref].setValue("");
                this.$refs[this.NOM_TIP_PARTENR.ref].setValue(0);
                this.$refs[this.CUI.ref].setValue("");
                this.$refs[this.RO.ref].setValue(false);
                this.$refs[this.SKIP_CHECK_COD.ref].setValue(false);
                this.$refs[this.REGCOM.ref].setValue("");
            },
            fillForm: function () {
                this.titleForm = this.dataPartener.cNume;
                this.$refs[this.NUME.ref].setValue(this.dataPartener.cNume);
                this.$refs[this.NOM_TIP_PARTENR.ref].setValue(this.dataPartener.id_tip);
                this.$refs[this.CUI.ref].setValue(this.dataPartener.cui);

                let withRo = false;
                if(this.dataPartener.ro_ === 'RO'){
                    withRo = true;
                }
                this.$refs[this.RO.ref].setValue(withRo);
                this.$refs[this.SKIP_CHECK_COD.ref].setValue(false);
                this.$refs[this.REGCOM.ref].setValue(this.dataPartener.regcom);
            },
            emitYesNoButton: function (yes) {
                if(yes == 1){
                    this.toServer.senData = true;
                    this.editServerDatePartener();
                }else{
                    this.toServer.senData = false;
                }
            },
            setPost: function (component, value){
                this.post['field'][component.name] = value;
            },
            setPostAction: function (value){
                this.post.sqlAction = value;
            },
            cfgTipPartener: function(){
                let cfg = this.$app.cfgSelectSimple('nomTipPartener', this.$url.getUrl('nomTipPartener'), 220);
                cfg.setValidateFunction(this.validateTipPartner);
                cfg.setCaption("Tip partener");
                cfg.setMandatory(true);
                return cfg;
            },
            cfgNume: function(){
                let cfg = this.$app.cfgInputField("nume", 120);
                cfg.setValidate(3,150);
                cfg.setValidateFunction(this.validateNume);
                cfg.setCaption("Nume");
                cfg.setMandatory(true);
                cfg.setMaska("");
                return cfg;
            },
            cfgRegCom: function(){
                let cfg = this.$app.cfgInputField("regcom", 20);
                cfg.setValidate(3,150);
                cfg.setValidateFunction(this.validateRegcom);
                cfg.setCaption("Cod registrul comertului");
                cfg.setMandatory(false);
                cfg.setMaska("");

                return cfg;
            },
            cfgCui: function(){
                let cfg = this.$app.cfgInputField("cui", 15);
                cfg.setValidate(3,13);
                cfg.setValidateFunction(this.validateCui);
                cfg.setCaption("CUI\\CNP");
                cfg.setMandatory(true);
                cfg.setMaska("");
                return cfg;
            },
            cfgRO: function (){
                let cfg = this.$app.cfgCheckBox('ro', false);
                cfg.setValidateFunction(this.validateRO);
                return cfg;
            },
            cfgSkipCheckCode: function (){
                let cfg = this.$app.cfgCheckBox('skipCheckCode', false);
                cfg.setValidateFunction(this.validateSkipCheckCode);
                return cfg;
            },
            validateNume: function () {
                let value = this.$refs[this.NUME.ref].getValue();
                if(!this.$check.lenghtMinMax(value, this.NUME.minLength, this.NUME.maxLength)){
                    this.form.message.push(this.$app.getFormMessageClass(this.NUME.id, this.NUME.caption,
                        'trebuie sa aiba minim ' + this.NUME.minLength + " si maxim " + this.NUME.maxLength + " caractere"));
                }

                this.setPost(this.NUME, value);
            },
            validateTipPartner: function () {
                let value = this.$refs[this.NOM_TIP_PARTENR.ref].getValue();
                if(value.id < 1){
                    this.form.message.push(this.$app.getFormMessageClass(this.NOM_TIP_PARTENR.id, this.NOM_TIP_PARTENR.caption,
                        'trebuie sa alegi organizarea juridica a partenerului'));
                }
                this.setPost(this.NOM_TIP_PARTENR, value.id);
            },
            validateCui: function () {
                let value = this.$refs[this.CUI.ref].getValue();
                let checkCode = false;
                let msg = null;
                let tipPartenerValue = this.$refs[this.NOM_TIP_PARTENR.ref].getValue();

                if(tipPartenerValue.candidateKey == this.$constBussines.PERSOANA_FIZICA){
                    msg = 'CNP invalid';
                    checkCode = this.$check.checkCode( this.$constBussines.RO_CNP ,value);
                }else{
                    msg = 'Codul fiscal este invalid';
                    checkCode = this.$check.checkCode( this.$constBussines.RO_CUI ,value);
                }


                let notCheckCode = this.$refs[this.SKIP_CHECK_COD.ref].getValue();

                if(!checkCode && !notCheckCode){
                    this.form.message.push(this.$app.getFormMessageClass(this.CUI.id, this.CUI.caption,msg));
                }

                this.setPost(this.CUI, value);
            },
            validateRO: function () {
                let value = this.$refs[this.RO.ref].getValue();
                this.setPost(this.RO, value);
            },
            validateSkipCheckCode: function (){
                let value = this.$refs[this.SKIP_CHECK_COD.ref].getValue();
                this.setPost(this.SKIP_CHECK_COD, value);
            },
            validateRegcom: function () {
                let value = this.$refs[this.REGCOM.ref].getValue();
                this.setPost(this.REGCOM, value);
            }
        },
        data () {
            return {
                toServer: {senData: false},
                form: {message: []},
                captionButton: "Modific datele",
                dataPartener: null,
                titleForm: '...',
                post: { idPk: null, field: {}, sqlAction: null}

            }
        }
    }

</script>

<style scoped></style>
