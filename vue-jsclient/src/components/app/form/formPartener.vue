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

    <form-tab>
        <template v-slot:slotContent>
            <form>
                <table class="ff-form-table">
                    <tr>
                        <td class="label-left bold">
                            <label :for=NUME.id>{{NUME.caption}}</label></td>
                        <td class="control">
                            <name-field
                                :id = NUME.id
                                :ref = NUME.ref
                                maska=""
                                :minlength = NUME.minLength
                                :maxlength = NUME.maxLength
                                :size = NUME.sizeField
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
                                :id = CUI.id
                                :ref = CUI.ref
                                maska=""
                                :minlength = CUI.minLength
                                :maxlength = CUI.maxLength
                                :size = CUI.sizeField
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
                                :id = REGCOM.id
                                :ref = REGCOM.ref
                                maska=""
                                :minlength = REGCOM.minLength
                                :maxlength = REGCOM.maxLength
                                :size = REGCOM.sizeField
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

    export default {
        components: {
            'form-tab': FormTab,
            'validate-window': AlertWindow,
            'name-field': InputField,
            'type-partener': DropDownSimple,
            'with-ro': CheckBox
        },
        name: "form-partener",
        created() {
            this.NUME = this.cfgNume();
            this.NOM_TIP_PARTENR = this.cfgTipPartener();
            this.CUI = this.cfgCui();
            this.RO = this.cfgRO();
            this.REGCOM = this.cfgRegCom();
        },
        mounted () {
        },
        methods: {
            fillForm: function (record) {
                this.$refs[this.NUME.ref].setValue(record[0].cNume);
                this.$refs[this.NOM_TIP_PARTENR.ref].setValue(record[0].id_tip);
                this.$refs[this.CUI.ref].setValue(record[0].cui);

                let withRo = false;
                if(record[0].ro_ == 'RO'){
                    withRo = true;
                }
                this.$refs[this.RO.ref].setValue(withRo);
                this.$refs[this.REGCOM.ref].setValue(record[0].regcom);

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
                let cfg = this.$app.cfgTextFIeld();
                cfg.setIdAndRef("nume");
                cfg.minLength   = 3;
                cfg.maxLength   = 150;
                cfg.validate    = this.validateNume;
                cfg.maska       = "";
                cfg.caption     = "Nume";
                cfg.mandatory   = true;
                cfg.sizeField  = 120;

                return cfg;
            },
            cfgRegCom: function(){
                let cfg = this.$app.cfgTextFIeld();
                cfg.setIdAndRef("regcom");
                cfg.minLength   = 3;
                cfg.maxLength   = 150;
                cfg.validate    = this.validateRegcom;
                cfg.maska       = "";
                cfg.caption     = "Cod registrul comertului";
                cfg.mandatory   = false;
                cfg.sizeField  = 20;

                return cfg;
            },
            cfgCui: function(){
                let cfg = this.$app.cfgTextFIeld();
                cfg.setIdAndRef("cui");
                cfg.minLength   = 3;
                cfg.maxLength   = 13;
                cfg.validate    = this.validateCui;
                cfg.maska       = "";
                cfg.caption     = "CUI";
                cfg.mandatory   = true;
                cfg.sizeField  = 15;

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
            }
        }
    }

</script>

<style scoped></style>
