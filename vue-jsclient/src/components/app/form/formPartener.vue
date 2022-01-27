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
                                :validate = NUME.validate
                                :minlength = NUME.minLength
                                :maxlength = NUME.maxLength
                                :size = NUME.sizeField
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

    export default {
        components: {
            'form-tab': FormTab,
            'validate-window': AlertWindow,
            'name-field': InputField,
        },
        name: "form-partener",
        created() {
            this.NUME       = this.cfgNume();
        },
        mounted () {
        },
        methods: {
            fillForm: function (record) {
                this.$refs[this.NUME.ref].setValue(record[0].cNume);
            },
            emitYesNoButton: function () {
            },
            cfgNume: function(){
                let cfg = this.$app.cfgTextFIeld();
                cfg.setIdAndRef("nume");
                cfg.minLength   = 3;
                cfg.maxLength   = 150;
                cfg.validate    = this.validateNume;
                cfg.maska       = "";
                cfg.caption     = "Nume";
                cfg.mandatory   = false;
                cfg.sizeField  = 120;

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
