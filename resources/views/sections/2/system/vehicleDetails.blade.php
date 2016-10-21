<div id="vehicle-details-block" class="col-lg-12 block">
    <h1>Vehicle Details</h1>
    <br>

    <div class="panel-group" id="vehicle-details-accordion" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="vehicle-details-general-heading">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#vehicle-details-accordion" href="#vehicle-details-general" aria-expanded="true" aria-controls="vehicle-details-general">
                        Vehicle type
                    </a>
                </h4>
            </div>

            <div id="vehicle-details-general" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="vehicle-details-general-heading">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <label class="control-label">Name:</label>
                        </div>

                        <div class="col-lg-8">
                            <span id="vehicle-details-name"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <label class="control-label">Type:</label>
                        </div>

                        <div class="col-lg-8">
                            <span id="vehicle-details-type"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <label class="control-label">Max speed:</label>
                        </div>

                        <div class="col-lg-8">
                            <span id="vehicle-details-max-speed"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <label class="control-label">Notes:</label>
                        </div>

                        <div class="col-lg-8">
                            <p id="vehicle-details-notes"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="vehicle-details-from-to-heading">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#vehicle-details-accordion" href="#vehicle-details-from-to" aria-expanded="false" aria-controls="vehicle-details-from-to">
                        Address & Time
                    </a>
                </h4>
            </div>

            <div id="vehicle-details-from-to" class="panel-collapse collapse" role="tabpanel" aria-labelledby="vehicle-details-from-to-heading">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <label class="control-label">From address:</label>
                        </div>

                        <div class="col-lg-6">
                            <span id="vehicle-details-from-address"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <label class="control-label">From city:</label>
                        </div>

                        <div class="col-lg-6">
                            <span id="vehicle-details-from-city"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <label class="control-label">Time from:</label>
                        </div>

                        <div class="col-lg-6">
                            <span id="vehicle-details-time-from"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <label class="control-label">To address:</label>
                        </div>

                        <div class="col-lg-6">
                            <span id="vehicle-details-to-address"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <label class="control-label">To city:</label>
                        </div>

                        <div class="col-lg-6">
                            <span id="vehicle-details-to-city"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <label class="control-label">Time to:</label>
                        </div>

                        <div class="col-lg-6">
                            <span id="vehicle-details-time-to"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="vehicle-details-costs-heading">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#vehicle-details-accordion" href="#vehicle-details-costs" aria-expanded="false" aria-controls="vehicle-details-costs">
                        Costs
                    </a>
                </h4>
            </div>

            <div id="vehicle-details-costs" class="panel-collapse collapse" role="tabpanel" aria-labelledby="vehicle-details-costs-heading">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <label class="control-label">€/task cost:</label>
                        </div>

                        <div class="col-lg-8">
                            <span id="vehicle-details-eur-task"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <label class="control-label">€/km cost:</label>
                        </div>

                        <div class="col-lg-8">
                            <span id="vehicle-details-eur-km"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <label class="control-label">€/h cost:</label>
                        </div>

                        <div class="col-lg-8">
                            <span id="vehicle-details-eur-h"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="vehicle-details-passengers-heading">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#vehicle-details-accordion" href="#vehicle-details-passengers" aria-expanded="false" aria-controls="vehicle-details-passengers">
                        For Passengers
                    </a>
                </h4>
            </div>

            <div id="vehicle-details-passengers" class="panel-collapse collapse" role="tabpanel" aria-labelledby="vehicle-details-passengers-heading">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <label class="control-label">Max passengers:</label>
                        </div>

                        <div class="col-lg-6">
                            <span id="vehicle-details-max-passengers"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="vehicle-details-cargo-heading">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#vehicle-details-accordion" href="#vehicle-details-cargo" aria-expanded="false" aria-controls="vehicle-details-cargo">
                        For Cargo
                    </a>
                </h4>
            </div>

            <div id="vehicle-details-cargo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="vehicle-details-cargo-heading">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <label class="control-label">Cargo space length:</label>
                        </div>

                        <div class="col-lg-4">
                            <span id="vehicle-details-trunk-length"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8">
                            <label class="control-label">Cargo space width:</label>
                        </div>

                        <div class="col-lg-4">
                            <span id="vehicle-details-trunk-width"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8">
                            <label class="control-label">Cargo space height:</label>
                        </div>

                        <div class="col-lg-4">
                            <span id="vehicle-details-trunk-height"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8">
                            <label class="control-label">Total volume:</label>
                        </div>

                        <div class="col-lg-4">
                            <span id="vehicle-details-total-volume"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8">
                            <label class="control-label">Max weight:</label>
                        </div>

                        <div class="col-lg-4">
                            <span id="vehicle-details-max-weight"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8">
                            <label class="control-label">Weather protection:</label>
                        </div>

                        <div class="col-lg-4">
                            <span id="vehicle-details-weather-protection"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8">
                            <label class="control-label">Food accepted:</label>
                        </div>

                        <div class="col-lg-4">
                            <span id="vehicle-details-food"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8">
                            <label class="control-label">Crane:</label>
                        </div>

                        <div class="col-lg-4">
                            <span id="vehicle-details-crane"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8">
                            <label class="control-label">Rear lift:</label>
                        </div>

                        <div class="col-lg-4">
                            <span id="vehicle-details-rear-lift"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8">
                            <label class="control-label">Temperature control:</label>
                        </div>

                        <div class="col-lg-4">
                            <span id="vehicle-details-temp-control"></span>
                        </div>
                    </div>

                    <div class="row" id="view-vehicle-min-temperature-value">
                        <div class="col-lg-8">
                            <label class="control-label">Min temperature:</label>
                        </div>

                        <div class="col-lg-4">
                            <span id="vehicle-details-min-temp"></span>
                        </div>
                    </div>

                    <div class="row" id="view-vehicle-max-temperature-value">
                        <div class="col-lg-8">
                            <label class="control-label">Max temperature:</label>
                        </div>

                        <div class="col-lg-4">
                            <span id="vehicle-details-max-temp"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>