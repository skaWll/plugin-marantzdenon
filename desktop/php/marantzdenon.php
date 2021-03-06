<?php
if (!isConnect('admin')) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
$plugin = plugin::byId('marantzdenon');
sendVarToJS('eqType', $plugin->getId());
$eqLogics = eqLogic::byType($plugin->getId());

?> 

<div class="row row-overflow">
  <div class="col-lg-2 col-md-3 col-sm-4">
    <div class="bs-sidebar">
      <ul id="ul_eqLogic" class="nav nav-list bs-sidenav">
        <a class="btn btn-default eqLogicAction" style="width : 100%;margin-top : 5px;margin-bottom: 5px;" data-action="add"><i class="fa fa-plus-circle"></i> {{Ajouter un template}}</a>
        <li class="filter" style="margin-bottom: 5px;"><input class="filter form-control input-sm" placeholder="{{Rechercher}}" style="width: 100%"/></li>
        <?php
foreach ($eqLogics as $eqLogic) {
	echo '<li class="cursor li_eqLogic" data-eqLogic_id="' . $eqLogic->getId() . '"><a>' . $eqLogic->getHumanName(true) . '</a></li>';
}
?>
     </ul>
   </div>
 </div>

 <div class="col-lg-10 col-md-9 col-sm-8 eqLogicThumbnailDisplay" style="border-left: solid 1px #EEE; padding-left: 25px;">
  <legend>{{Gestion}}</legend>
  <div class="eqLogicThumbnailContainer">
    <div class="cursor eqLogicAction" data-action="add" style="text-align: center; background-color : #ffffff; height : 120px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;" >
      <i class="fa fa-plus-circle" style="font-size : 5em;color:#94ca02;"></i>
      <br>
      <span style="font-size : 1.1em;position:relative; top : 23px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#94ca02">{{Ajouter}}</span>
    </div>
 </div>

<legend><i class="fa fa-table"></i> {{Mes Amplis}}</legend>
    <input class="form-control" placeholder="{{Rechercher}}" style="margin-bottom:4px;" id="in_searchEqlogic" />
    <div class="eqLogicThumbnailContainer">
    <?php
foreach ($eqLogics as $eqLogic) {
	echo '<div class="eqLogicDisplayCard cursor" data-eqLogic_id="' . $eqLogic->getId() . '" style="text-align: center; background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;" >';
	echo '<img src="' . $plugin->getPathImgIcon() . '" height="105" width="95" />';
	echo "<br>";
	echo '<span class="name" style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;">' . $eqLogic->getHumanName(true, true) . '</span>';
	echo '</div>';
}
?>
 </div>
</div>

<div class="col-lg-10 col-md-9 col-sm-8 eqLogic" style="border-left: solid 1px #EEE; padding-left: 25px;display: none;">
 <a class="btn btn-success eqLogicAction pull-right" data-action="save"><i class="fa fa-check-circle"></i> {{Sauvegarder}}</a>
 <a class="btn btn-danger eqLogicAction pull-right" data-action="remove"><i class="fa fa-minus-circle"></i> {{Supprimer}}</a>
 <a class="btn btn-default eqLogicAction pull-right" data-action="configure"><i class="fa fa-cogs"></i> {{Configuration avancée}}</a>
 <ul class="nav nav-tabs" role="tablist">
   <li role="presentation"><a class="eqLogicAction cursor" aria-controls="home" role="tab" data-action="returnToThumbnailDisplay"><i class="fa fa-arrow-circle-left"></i></a></li>
   <li role="presentation" class="active"><a href="#eqlogictab" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-tachometer"></i> {{Equipement}}</a></li>
   <li role="presentation"><a href="#commandtab" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-list-alt"></i> {{Commandes}}</a></li>
 </ul>
 <div class="tab-content" style="height:calc(100% - 50px);overflow:auto;overflow-x: hidden;">
  <div role="tabpanel" class="tab-pane active" id="eqlogictab">
    <br/>
    <form class="form-horizontal">
      <fieldset>
        <div class="form-group">
          <label class="col-sm-3 control-label">{{Nom de l'équipement}}</label>
          <div class="col-sm-3">
            <input type="text" class="eqLogicAttr form-control" data-l1key="id" style="display : none;" />
            <input type="text" class="eqLogicAttr form-control" data-l1key="name" placeholder="{{Nom de l'équipement}}"/>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label" >{{Objet parent}}</label>
          <div class="col-sm-3">
            <select id="sel_object" class="eqLogicAttr form-control" data-l1key="object_id">
              <option value="">{{Aucun}}</option>
              <?php
foreach (object::all() as $object) {
	echo '<option value="' . $object->getId() . '">' . $object->getName() . '</option>';
}
?>
           </select>
         </div>
       </div>
       <div class="form-group">
         <label class="col-sm-3 control-label"></label>
         <div class="col-sm-8">
          <label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isEnable" checked/>{{Activer}}</label>
          <label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isVisible" checked/>{{Visible}}</label>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label">{{IP}}</label>
        <div class="col-sm-3">
          <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="ip" placeholder="{{X.X.X.X ou X.X.X.X:8080}}"/>
        </div>
		L'ajout de ':8080' est uniquement nécessaire pour certain modèles (après 2016)
      </div>
		<!---->
	  <div class="form-group">
        <label class="col-sm-3 control-label">{{Modèle identifié}}</label>
        <div class="col-sm-3">
          <input type="text" readonly class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="modelInfo" />
        </div>
      </div>
	  <div class="form-group">
        <label class="col-sm-3 control-label">{{Modèle}}</label>
        <div class="col-sm-3">
          <select type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="modelType" >
            <option value="auto">Auto</option>
			<option value="NoInput">{{Ne pas créer d'entrées}}</option>
<?php
	if ($eqLogic) {
		foreach ($eqLogic->getModelDescriptions() as $key => $value){
			echo '<option value="' .$key. '">' .$value['Name']. '</option>';
		}
	}
?> 
          </select>
        </div>
		<i>Essayez plusieurs modèles afn de trouver la configuration la plus proche.</i>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label">{{Zone}}</label>
        <div class="col-sm-3">
          <select type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="zone" >
            <option value="main">Principale</option>
            <option value="2">2</option>
			<option value="3">3</option>
          </select>
        </div>
      </div>
	  <div class="form-group">
        <label class="col-sm-3 control-label">{{Nombre de favoris}}</label>
        <div class="col-sm-3">
          <input type="number" min="0" max="4" value="3" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="favoriCount" />
        </div>
      </div>
	  <div class="form-group">
        <label class="col-sm-3 control-label">{{Volume maximum}}</label>
        <div class="col-sm-3">
          <input type="number" min="0" max="98" value="30" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="volumemax" />
        </div>
		Valeur entre 0 et 98 (0 = désactivé)
      </div>
	  <div class="form-group">
        <label class="col-sm-3 control-label">{{Volume par défaut}}</label>
        <div class="col-sm-3">
          <input type="number" min="0" max="98" value="7" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="volumedefault" />
        </div>
		Valeur entre 0 et 98 (0 = désactivé)
      </div>
	  <div class="form-group">
        <label class="col-sm-3 control-label">{{Durée Veille par défaut}}</label>
        <div class="col-sm-3">
          <input type="number" min="0" max="120" value="0" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="sleepdefault" />
        </div>
		Valeur entre 0 et 120 minutes (0 = désactivé)
      </div>
	  <div class="form-group">
		  <label class="col-sm-3 control-label">{{Pas volume +/-}}</label>
		  <div class="col-sm-3">
			<input type="number" min="1" max="10" value="1" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="volumestep" />
		  </div>
		Valeur entre 1 et 10 (défaut = 1)
	  </div>
      <div class="form-group">
        <label class="col-sm-3 control-label">{{Peut être éteint}}</label>
        <div class="col-sm-3">
          <input type="checkbox" class="eqLogicAttr" data-l1key="configuration" data-l2key="canBeShutdown" />
        </div>
      </div>
    </fieldset>
  </form>

</div>
<div role="tabpanel" class="tab-pane" id="commandtab">
  <a class="btn btn-success btn-sm cmdAction pull-right" data-action="add" style="margin-top:5px;"><i class="fa fa-plus-circle"></i> {{Ajouter une commande}}</a><br/><br/>
  <table id="table_cmd" class="table table-bordered table-condensed">
    <thead>
      <tr>
        <th style="width: 300px;">{{Nom}}</th>
        <th style="width: 130px;">Type</th>
        <!--<th>{{Logical ID (info) ou Commande brute (action)}}</th>-->
		<th>{{Commande brute}}</th>
        <th>{{Paramètres}}</th>
        <th style="width: 100px;">{{Options}}</th>
        <th>{{Action}}</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
</div>
</div>

</div>
</div>

<?php include_file('desktop', 'marantzdenon', 'js', 'marantzdenon');?>
<?php include_file('core', 'plugin.template', 'js');?>
