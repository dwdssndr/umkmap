var wms_layers = [];
var baseLayer = new ol.layer.Group({
    'title': '',
    layers: [
new ol.layer.Tile({
    'title': 'OSM',
    'type': 'base',
    source: new ol.source.OSM()
})
]
});
var format_SMK_0 = new ol.format.GeoJSON();
var features_SMK_0 = format_SMK_0.readFeatures(json_SMK_0, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:3857'});
var jsonSource_SMK_0 = new ol.source.Vector({
    attributions: [new ol.Attribution({html: '<a href=""></a>'})],
});
jsonSource_SMK_0.addFeatures(features_SMK_0);var lyr_SMK_0 = new ol.layer.Vector({
                declutter: true,
                source:jsonSource_SMK_0, 
                style: style_SMK_0,
    title: 'SMK<br />\
    <img src="styles/legend/SMK_0_0.png" />  0.00 - 0.60 <br />\
    <img src="styles/legend/SMK_0_1.png" />  0.60 - 1.20 <br />\
    <img src="styles/legend/SMK_0_2.png" />  1.20 - 1.80 <br />\
    <img src="styles/legend/SMK_0_3.png" />  1.80 - 2.40 <br />\
    <img src="styles/legend/SMK_0_4.png" />  2.40 - 3.00 <br />'
        });var format_SMA_1 = new ol.format.GeoJSON();
var features_SMA_1 = format_SMA_1.readFeatures(json_SMA_1, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:3857'});
var jsonSource_SMA_1 = new ol.source.Vector({
    attributions: [new ol.Attribution({html: '<a href=""></a>'})],
});
jsonSource_SMA_1.addFeatures(features_SMA_1);var lyr_SMA_1 = new ol.layer.Vector({
                declutter: true,
                source:jsonSource_SMA_1, 
                style: style_SMA_1,
    title: 'SMA<br />\
    <img src="styles/legend/SMA_1_0.png" />  0.00 - 0.20 <br />\
    <img src="styles/legend/SMA_1_1.png" />  0.20 - 0.40 <br />\
    <img src="styles/legend/SMA_1_2.png" />  0.40 - 0.60 <br />\
    <img src="styles/legend/SMA_1_3.png" />  0.60 - 0.80 <br />\
    <img src="styles/legend/SMA_1_4.png" />  0.80 - 1.00 <br />'
        });var format_SMP_2 = new ol.format.GeoJSON();
var features_SMP_2 = format_SMP_2.readFeatures(json_SMP_2, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:3857'});
var jsonSource_SMP_2 = new ol.source.Vector({
    attributions: [new ol.Attribution({html: '<a href=""></a>'})],
});
jsonSource_SMP_2.addFeatures(features_SMP_2);var lyr_SMP_2 = new ol.layer.Vector({
                declutter: true,
                source:jsonSource_SMP_2, 
                style: style_SMP_2,
    title: 'SMP<br />\
    <img src="styles/legend/SMP_2_0.png" />  1 - 2 <br />\
    <img src="styles/legend/SMP_2_1.png" />  2 - 3 <br />\
    <img src="styles/legend/SMP_2_2.png" />  3 - 4 <br />\
    <img src="styles/legend/SMP_2_3.png" />  4 - 5 <br />\
    <img src="styles/legend/SMP_2_4.png" />  5 - 6 <br />'
        });var format_SD_3 = new ol.format.GeoJSON();
var features_SD_3 = format_SD_3.readFeatures(json_SD_3, 
            {dataProjection: 'EPSG:4326', featureProjection: 'EPSG:3857'});
var jsonSource_SD_3 = new ol.source.Vector({
    attributions: [new ol.Attribution({html: '<a href=""></a>'})],
});
jsonSource_SD_3.addFeatures(features_SD_3);var lyr_SD_3 = new ol.layer.Vector({
                declutter: true,
                source:jsonSource_SD_3, 
                style: style_SD_3,
    title: 'SD<br />\
    <img src="styles/legend/SD_3_0.png" />  14 - 20 <br />\
    <img src="styles/legend/SD_3_1.png" />  20 - 27 <br />\
    <img src="styles/legend/SD_3_2.png" />  27 - 33 <br />\
    <img src="styles/legend/SD_3_3.png" />  33 - 40 <br />\
    <img src="styles/legend/SD_3_4.png" />  40 - 46 <br />'
        });

lyr_SMK_0.setVisible(false);lyr_SMA_1.setVisible(false);lyr_SMP_2.setVisible(false);lyr_SD_3.setVisible(true);
var layersList = [baseLayer,lyr_SMK_0,lyr_SMA_1,lyr_SMP_2,lyr_SD_3];
lyr_SMK_0.set('fieldAliases', {'ID': 'ID', 'ID_Kec': 'ID_Kec', 'Kecamatan': 'Kecamatan', 'jml_SMK': 'jml_SMK', 'jml_murid': 'jml_murid', 'jml_guru': 'jml_guru', });
lyr_SMA_1.set('fieldAliases', {'ID': 'ID', 'ID_Kec': 'ID_Kec', 'Kecamatan': 'Kecamatan', 'jml_SMA': 'jml_SMA', 'jml_murid': 'jml_murid', 'jml_guru': 'jml_guru', });
lyr_SMP_2.set('fieldAliases', {'ID': 'ID', 'ID_Kec': 'ID_Kec', 'Kecamatan': 'Kecamatan', 'jml_SMP': 'jml_SMP', 'jml_murid': 'jml_murid', 'jml_guru': 'jml_guru', });
lyr_SD_3.set('fieldAliases', {'ID': 'ID', 'ID_Kec': 'ID_Kec', 'Kecamatan': 'Kecamatan', 'jml_SD': 'jml_SD', 'jml_murid': 'jml_murid', 'jml_guru': 'jml_guru', });
lyr_SMK_0.set('fieldImages', {'ID': 'TextEdit', 'ID_Kec': 'TextEdit', 'Kecamatan': 'TextEdit', 'jml_SMK': 'TextEdit', 'jml_murid': 'TextEdit', 'jml_guru': 'TextEdit', });
lyr_SMA_1.set('fieldImages', {'ID': 'TextEdit', 'ID_Kec': 'TextEdit', 'Kecamatan': 'TextEdit', 'jml_SMA': 'TextEdit', 'jml_murid': 'TextEdit', 'jml_guru': 'TextEdit', });
lyr_SMP_2.set('fieldImages', {'ID': 'TextEdit', 'ID_Kec': 'TextEdit', 'Kecamatan': 'TextEdit', 'jml_SMP': 'TextEdit', 'jml_murid': 'TextEdit', 'jml_guru': 'TextEdit', });
lyr_SD_3.set('fieldImages', {'ID': 'TextEdit', 'ID_Kec': 'TextEdit', 'Kecamatan': 'TextEdit', 'jml_SD': 'TextEdit', 'jml_murid': 'TextEdit', 'jml_guru': 'TextEdit', });
lyr_SMK_0.set('fieldLabels', {'ID': 'no label', 'ID_Kec': 'no label', 'Kecamatan': 'inline label', 'jml_SMK': 'inline label', 'jml_murid': 'inline label', 'jml_guru': 'inline label', });
lyr_SMA_1.set('fieldLabels', {'ID': 'no label', 'ID_Kec': 'no label', 'Kecamatan': 'inline label', 'jml_SMA': 'inline label', 'jml_murid': 'inline label', 'jml_guru': 'inline label', });
lyr_SMP_2.set('fieldLabels', {'ID': 'no label', 'ID_Kec': 'no label', 'Kecamatan': 'inline label', 'jml_SMP': 'inline label', 'jml_murid': 'inline label', 'jml_guru': 'inline label', });
lyr_SD_3.set('fieldLabels', {'ID': 'no label', 'ID_Kec': 'no label', 'Kecamatan': 'inline label', 'jml_SD': 'inline label', 'jml_murid': 'inline label', 'jml_guru': 'inline label', });
lyr_SD_3.on('precompose', function(evt) {
    evt.context.globalCompositeOperation = 'normal';
});