<script type="text/Javascript">
    var noMatchesFound = "<?php echo $words->getSilent('SearchNoMatchesFound');?>";
</script><?php
/**
 * trip createform template
 *
 * @package trip
 * @subpackage template
 * @author The myTravelbook Team <http://www.sourceforge.net/projects/mytravelbook>
 * @copyright Copyright (c) 2005-2006, myTravelbook Team
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License (GPL)
 * @version $Id$
 */
$formKit = $this->layoutkit->formkit;
$callback_tag = $formKit->setPostCallback('TripsController', 'editCreateCallback');

$errors = $this->getRedirectedMem('errors');
$tripInfo = $this->getRedirectedMem('tripInfo');
if (empty($tripInfo)) {
    $tripInfo = $this->vars;
}

$member = $this->member;
$words = $this->getWords();
if ($this->_editing == true) {
    $panelTitle = $words->get('Triptitle_edit');
    $buttonTitle = $words->getSilent('TripSubmit_edit');
} else {
    $panelTitle = $words->get('TripTitle_create');
    $buttonTitle = $words->getSilent('TripSubmit_create');
}
?>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-7">
            <h2><?= $panelTitle ?></h2>
        </div>
        <div class="col-md-3"></div>
    </div>

        <form method="post" class="tripseditcreate" role="form">
            <?= $callback_tag; ?>
            <input type="hidden" name="trip-id" value="<?= $tripInfo['trip-id'] ?>" >

            <div class="row">
                <div class="col-md-2">
                    <?php if (in_array('TripErrorNameEmpty', $errors)) : ?>
                        <span class="alert alert-danger p-x-1 p-y-0"><small><?= $words->get('TripErrorNameEmpty') ?></small></span>
                    <?php endif; ?>
                </div>
                <div class="col-md-7">
                    <div class="form-group">
                        <label for="trip-title"
                               class="control-label sr-only"><?php echo $words->get('TripNameLabel'); ?></label>
                        <input type="text" class="form-control" name="trip-title"
                               placeholder="<?= $words->getBuffered('TripNamePlaceholder'); ?>"
                               value="<?= htmlentities($tripInfo['trip-title'], ENT_COMPAT, 'utf-8') ?>" />
                    </div>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-outline-primary" data-container="body" data-toggle="popover" data-placement="right" data-content="Help on Title">
                        ?
                    </button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2">
                    <?php if (in_array('TripErrorDescriptionEmpty', $errors)) : ?>
                        <span class="alert alert-danger p-x-1 p-y-0"><small><?= $words->get('TripErrorDescriptionEmpty') ?></small></span>
                    <?php endif; ?>
                </div>
                <div class="col-md-7">
                    <div class="form-group">
                        <label for="trip-description" class="control-label sr-only"><?= $words->get('TripDescriptionLabel'); ?></label>
                    <textarea class="form-control" name="trip-description" cols="48" rows="7"
                              placeholder="<?= $words->getBuffered('TripDescriptionPlaceholder') ?>"><?php
                        if (!empty($tripInfo['trip-description'])) {
                            echo htmlentities($tripInfo['trip-description'], ENT_COMPAT, 'utf-8');
                        } ?></textarea>
                    </div>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-outline-primary" data-container="body" data-toggle="popover" data-placement="right" data-content="Help on Description">
                        ?
                    </button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2">
                    <?php if (in_array('TripErrorNumberOfPartyMissing', $errors)) : ?>
                        <span class="alert alert-danger p-x-1 p-y-0"><small><?= $words->get('TripErrorNumberOfPartyMissing') ?></small></span>
                    <?php endif; ?>
                    <?php if (in_array('TripErrorCountAdditionalMismatch', $errors)) : ?>
                        <span class="alert alert-danger p-x-1 p-y-0"><small><?= $words->get('TripErrorCountAdditionalMismatch') ?></small></span>
                    <?php endif; ?>
                </div>
                <div class="col-md-3 form-group">
                    <label for="trip-count" class="control-label sr-only">
                        <?php echo $words->get('TripCountLabel'); ?>
                    </label>
                    <?= _getCountDropdown($tripInfo['trip-count'], $words->getBuffered('TripCountPlaceholder')) ?>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-outline-primary" data-container="body" data-toggle="popover" data-placement="right" data-content="Help on Extras">
                        ?
                    </button>
                </div>
                <div class="col-md-3 form-group">
                    <label for="trip-additional-info" class="control-label sr-only">
                        <?php echo $words->get('TripAdditionalInfoLabel'); ?>
                    </label>
                    <?= _getAdditionalInfoDropdown($tripInfo['trip-additional-info'], $words) ?>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-outline-primary" data-container="body" data-toggle="popover" data-placement="right" data-content="Help on Extras">
                        ?
                    </button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2">
                    <?php
                    if (in_array('TripErrorOverlappingDates', $errors)) {
                        echo '<span class="alert alert-danger p-x-1 p-y-0"><small>' . $words->get('TripErrorOverlappingDates') . '</small></span>';
                    }
                    ?>
                    <?php
                    if (in_array('TripErrorNoLocationSpecified', $errors)) {
                        echo '<span class="alert alert-danger p-x-1 p-y-0"><small>' . $words->get('TripErrorNoLocationSpecified') . '</small></span>';
                    }
                    ?>

                </div>
                <div class="col-md-7">
                    <?php
                    $locationRow=0;
                    foreach($tripInfo['locations'] as $locationDetails) :
                        $locationRow++; ?>
                        <div id="div-location-<?= $locationRow ?>">
                            <?php include SCRIPT_BASE . '/build/trips/templates/locationrow.php'; ?>
                        </div>
                    <?php endforeach; ?>
                    <div id="empty-location"><img id="location-loading"
                                                  src="/styles/css/minimal/screen/custom/jquery-ui/smoothness/images/ui-anim_basic_16x16.gif" alt="loading..." style="display:none;">
                    </div>

                    <?php $map_conf = PVars::getObj('map'); ?>
                    <input type="hidden" id="osm-tiles-provider-base-url" value="<?php echo ($map_conf->osm_tiles_provider_base_url); ?>"/>
                    <input type="hidden" id="osm-tiles-provider-api-key" value="<?php echo ($map_conf->osm_tiles_provider_api_key); ?>"/>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="trips-map" class="map"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-outline-primary" data-container="body" data-toggle="popover" data-placement="right" data-content="Help on Locations">
                        ?
                    </button></div>
            </div>
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-7">
                    <input type="hidden" name="trip-id" value="<?= $tripInfo['trip-id'] ?>"/>
                    <input type="submit" class="btn btn-primary"
                           value="<?= $buttonTitle ?>"/><?php echo $words->flushBuffer(); ?>
                </div>
                <div class="col-md-3"></div>
            </div>
            </form>

            <div class="panel panel-default">
                <div class="panel-heading"><?= $words->get("TripsLocations") ?></div>
                <div class="panel-body">


                </div>
            </div>

