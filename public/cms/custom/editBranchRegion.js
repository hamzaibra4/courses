
$(document).ready(function () {
    preAssignedRegions.forEach(region => {
        addRegionToTable(region.id, region.name);
    });
});
