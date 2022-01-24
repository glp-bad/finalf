<template>
    <div class="ff-workbench" ref="refWorkBench">
        <tab-parteneri ref="refTab"
            :pConfig=this.tabConfig
            @emitClickTab="emitClickTab"
        >
            <template v-slot:tabs>
                <div class="tab" :id="this.$constTab.getIdTab('1p')">
                    <div class="up-line">test</div>
                    <grid-parteneri ref="gridParteneri"
                             :pConfig=this.gridConfig
                    ></grid-parteneri>
                </div>
                <div class="tab" :id="this.$constTab.getIdTab('2p')">
                    <div class="up-line"></div>
                </div>
            </template>
        </tab-parteneri>

    </div>
</template>

<script>
    import Tab from "@/components/base/Tab";
    import Gridul from '@/components/base/Gridul';

    export default {
		components: {
            'tab-parteneri': Tab,
            'grid-parteneri' : Gridul
        },
		name: "view-parteneri",
		created() {
            this.tabConfig = {
                header: [
                    this.$constTab.getHeader('1p','Parteneri'),
                    this.$constTab.getHeader('2p','Paretener nou'),
                ],
                defaultTabId: '1p',
                tabsWidth: '1040px'
            },
            this.gridConfig = {
                    header: [
                        this.$constGrid.HEADER.getHeader(1,'Nume',450,'cNume', this.$constGrid.HEADER.CAPTION_TYPE_FIELD, true, true, true, null),
                        this.$constGrid.HEADER.getHeader(2,'Organizare',180,'cTipAbrev', this.$constGrid.HEADER.CAPTION_TYPE_FIELD, true, true, true, 't_tip_organizare_juridica.cTipAbrev'),
                        this.$constGrid.HEADER.getHeader(3,'Registrul comertului',180,'regcom', this.$constGrid.HEADER.CAPTION_TYPE_FIELD, true, false, true, null),
                        this.$constGrid.HEADER.getHeader(4,'RO',70,'ro_', this.$constGrid.HEADER.CAPTION_TYPE_FIELD, false, false, true, null),
                        this.$constGrid.HEADER.getHeader(5,'Cui',100,'cui', this.$constGrid.HEADER.CAPTION_TYPE_FIELD, false, false, true, null)


                    ],
                    actionButtonHeader: [
                        //this.$constGrid.getActionButton(7, 'Altceva din functie', 'altCeca', this.$constGrid.getIcon('fas','skull', '#adad00')),
                        // this.$constGrid.getActionButton(8, 'Print din functie', 'invoicePrint', this.$constGrid.ICON_PRINT)
                        //this.$constGrid.getActionButton(9, 'Edit din functie', 'deleteCeva', this.$constGrid.ICON_DELETE),
                        //this.$constGrid.getActionButton(10, 'Delete din functie', 'editCeva', this.$constGrid.ICON_EDIT)
                    ],
                    returnField: ['cNume', 'regcom'],             // return field and edit when selected row
                    cfg: {
                        width: 1100,
                        height: 500,
                        urlData: 'gridListParteneri'
                    },
                    toolbar: {
                        show: true,
                        fieldShow: {
                            field: ['cNume'],        // shon on selection with mouse or keyboard
                            separator: " ",
                            includeIdPk: true
                        },
                        actionButton : [
                            // this.$constGrid.getActionButton( null,  'Print din functie', 'invoicePrintToolbar', this.$constGrid.ICON_PRINT),
                            // this.$constGrid.getActionButton( null,  'Edit din functie',   'deleteCevaToolbar', this.$constGrid.ICON_DELETE),
                            // this.$constGrid.getActionButton( null,  'Delete din functie', 'editCevaToolbar', this.$constGrid.ICON_EDIT)
                        ]
                    },
                    paginate: {
                        nrButtonShow: 5,
                        recordsPerPage: 21
                    }
                }
		},
        mounted () {
		    this.$refs.refTab.goToTab(this.tabConfig.defaultTabId);
        },
		methods: {
		    emitClickTab: function (idTab) {
            }
		},
		data () {
			return {
            }
		}
	}

</script>

<style scoped></style>
