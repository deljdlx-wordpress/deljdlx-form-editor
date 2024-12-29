const deljdlxTreeNodeTypes = {
  root: {
    icon: "ri-home-2-line",
    childType: "cluster",
  },

  cluster: {
    icon: 'ri-database-2-line',
    defaultName: "New cluster",
    childType: "attribute",

  },

  attribute: {
    icon: "ri-circle-line",
    defaultName: "New attribute",
    childType: "field",
    // noChildren: true,
  },

  field: {
    icon: "ri-align-item-left-line",
    defaultName: "New field",
    noChildren: true,
  },

  default: {
    icon: "ri-square-line"
  },
}

