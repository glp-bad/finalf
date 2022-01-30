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
                            <name-field
                                :ref = NUME.ref
                                :pConfig = NUME
                            ></name-field></td>
                        <td class="control">
                            <type-partener
                                :ref = NOM_TIP_PARTENR.ref
                                :pId= NOM_TIP_PARTENR.id
                                :pName= NOM_TIP_PARTENR.id
                                pCaptionText= '...'
                                :pWidth= NOM_TIP_PARTENR.width
                                :pUrlData = NOM_TIP_PARTENR.url
                            ></type-partener></td>

                    </tr>

                    <tr>
                        <td class="label-left bold">
                            <label :for=CUI.id>{{CUI.caption}}</label></td>
                        <td class="control">
                            <name-field
                                :ref=CUI.ref
                                :pConfig = CUI
                            ></name-field>
                            <label> cu RO</label>
                            <with-ro
                                    :id= RO.id
                                    :ref= RO.ref
                                    :disabled= RO.disabled

                            ></with-ro>
                            &nbsp;&nbsp;
                            <label class="label-left bold">{{REGCOM.caption}}</label>
                            <name-field
                                :ref = REGCOM.ref
                                :pConfig = REGCOM
                            ></name-field>
                        </td>
                    </tr>
                </table>
            </form>
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
            'name-field': InputField,
            'type-partener': DropDownSimple,
            'with-ro': CheckBox,
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
            this.REGCOM = this.cfgRegCom();
            this.MODE = this.$constFROM.MODE_EDIT;
            this.ICON_ADD_PARTENER =  this.$constComponent.ICON_ADD_PERSON("blue");
            this.URL_GETDATA_PARTENER = this.$url.getUrl('partenerGetData');
        },
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

                        this.fillForm();
                        this.$refs[this.REF_FROM_PARTNER].showModal(false);
                    });
            },
            setModeForm: function (mode){
                this.MODE = mode;

                if(this.MODE == this.$constFROM.MODE_EDIT){
                    this.$refs[this.REF_BUTTON_ADD_PARTENER].disable(false);
                    console.log('transform formul in modul EDIT !!!!');
                }

                if(this.MODE == this.$constFROM.MODE_NEW){
                        console.log('transform formul in NEW !!!!');
                }

            },
            setFormNew: function (){
                this.$refs[this.REF_BUTTON_ADD_PARTENER].disable(true);
                this.setModeForm(this.$constFROM.MODE_NEW);
            },
            addNewPartner: function (){
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
                this.$refs[this.REGCOM.ref].setValue(this.dataPartener.regcom);

                this.setModeForm(this.$constFROM.MODE_EDIT);
            },
            emitYesNoButton: function () {
            },
            cfgTipPartener: function(){
                let cfg = this.$app.cfgSelectSimple();
                cfg.setIdAndRef("nomTipPartener");
                cfg.mandatory= true;
                cfg.caption= "Tip partener";
                cfg.width= 220;
                cfg.url = this.$url.getUrl('nomTipPartener');

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
                cfg.setCaption("CUI");
                cfg.setMandatory(true);
                cfg.setMaska("");
                return cfg;
            },
            cfgRO: function (){
                let cfg = this.$app.cfgCheckBox();
                cfg.setIdAndRef("ro");
                cfg.validate= this.validateRO;
                cfg.caption= "";
                cfg.defaultValue= false;
                cfg.disabled= false;

                return cfg;
            },
            validateNume: function () {
                if(!this.$check.lenghtMinMax(this.$refs[this.NUME.ref].getValue(), this.NUME.minLength, this.NUME.maxLength)){
                    this.messageForm.push(this.$app.getFormMessageClass(this.NUME.id, this.NUME.caption,
                        'trebuie sa aiba minim ' + this.NUME.minLength + " si maxim " + this.NUME.maxLength + " caractere"));
                }
            }
        },
        data () {
            return {
                dataPartener: null,
                titleForm: '...',
                post: { idPk: null}

            }
        }
    }

</script>

<style scoped></style>
