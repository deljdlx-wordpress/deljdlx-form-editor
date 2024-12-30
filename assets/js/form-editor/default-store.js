const deljdlxTreeStore = {
    ready: false,
    selectedNode: null,
    previousSelectedNode: null,


    availableAttributePoints: 10,
    availableSkillPoints: 100,
    availablePerks: 2,


    treeData: [{
        id: 'root',
        text: "Projet",
        type: "root",
        data: {
            code: 'ROOT',
        },
        "children": [
            {
                text: "Informations Générale", type: "cluster", id: "cluster-general",
                data: {
                    code: 'cluster-general',
                },
                children: [
                    {
                        text: "Nom du projet", type: "attribute", id: "attribute-name",
                        data: {
                            type: "text",
                            code: 'attribute-name',
                        },
                    },
                ]
            },
            {
                text: "Informations financières", type: "cluster", id: "cluster-financial",
                data: {
                    code: 'cluster-financial',
                },
                children: [
                    {
                        text: "Montant du projet", type: "attribute", id: "attribute-amount",
                        data: {
                            type: "number",
                            code: 'attribute-amount',
                        },
                    },
                    {
                        text: "Nombre de tokens", type: "attribute", id: "attribute-token-quantity",
                        data: {
                            type: "number",
                            code: 'attribute-token-quantity',
                        },
                    },
                    {
                        text: "Prix d'un token", type: "attribute", id: "attribute-token-price",
                        data: {
                            type: "number",
                            code: 'attribute-token-price',
                        },
                    },
                ]
            },
            {
                text: "Informations localisation", type: "cluster", id: "cluster-localisation",
                data: {
                    code: '',
                },
                children: [
                    {
                        text: "Région", type: "attribute", id: "attribute-province",
                        data: {
                            type: "text",
                            code: 'attribute-province',
                        },
                    },
                    {
                        text: "Département", type: "attribute", id: "attribute-department",
                        data: {
                            type: "text",
                            code: 'attribute-department',
                        },
                    },
                    {
                        text: "Ville", type: "attribute", id: "attribute-city",
                        data: {
                            type: "text",
                            code: 'attribute-city',
                        },
                    },
                    {
                        text: "Adresse", type: "attribute", id: "attribute-address",
                        data: {
                            type: "text",
                            code: 'attribute-address',
                        },
                    },
                ]
            },
            {
                text: "Informations éditoriales", type: "cluster", id: "cluster-editorial",
                data: {
                    code: '',
                },
                children: [
                    {
                        text: "Description du quartier", type: "attribute", id: "attribute-district-description",
                        data: {
                            type: "wysiwyg",
                            code: '',
                        },
                    },
                ]
            },
        ]
    }],
};
