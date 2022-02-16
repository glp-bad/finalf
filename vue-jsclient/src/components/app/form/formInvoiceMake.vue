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

    <validate-window ref="refYesNoNew"
                     :cWidth=300
                     :cHeight=200
                     :cTypeWindows=3
                     @emitYesNoButton = "emitYesNoButtonNew"
    ></validate-window>

    <form-tab :ref = this.REF_FORM>
        <template v-slot:slotTitle>
        </template>
        <template v-slot:slotContent>
            <my-dropdown-search :ref = this.cfgtime.INPUT_PARTNER.ref
                                :pConfig = this.cfgtime.INPUT_PARTNER
            ></my-dropdown-search>
        </template>
        <template v-slot:slotButton>
        </template>

    </form-tab>
</template>

<script>
    import AlertWindow      from "@/components/base/AlertWindow.vue";
    import FormTab          from "@/components/base/FormTab.vue";
    import DropDownSearch   from "@/components/base/DropDownSearch.vue";

    export default {
        components: {
            'validate-window': AlertWindow,
            'form-tab': FormTab,
            'my-dropdown-search': DropDownSearch
        },
        name: "form-invoice-make",
        created() {
            this.REF_FORM = 'refForm';
            this.runtime = {
                mode: this.$constFROM.MODE_EDIT,
                sendDataToServer: false,
	            message: [],
                post: { idPk: null, field: {}, sqlAction: null}
            };
            this.cfgtime = {
                INPUT_PARTNER: this.cfgDropDownPartner()
            };
        },
        emits: ['emitNewRecord'],
        mounted () {
        },
        methods: {
            cfgDropDownPartner: function(){
                let cfg = this.$app.cfgSelectSearch('nomPartner', this.$url.getUrl('listPartener'), 450);
                cfg.setValidateFunction(this.validatePartner);
                cfg.setCaption("Partener");
                cfg.setMandatory(true);
                return cfg;
            },
        },
        data () {
            return {
            }
        }
    }

</script>

<style scoped></style>
