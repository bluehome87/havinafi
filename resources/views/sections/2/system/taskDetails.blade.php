<div id="task-details-block" class="col-lg-12 block">
    <h1>Task Details</h1>
    <br>

    <div class="panel-group" id="task-details-accordion" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="task-details-general-heading">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#task-details-accordion" href="#task-details-general" aria-expanded="true" aria-controls="task-details-general">
                        Task type
                    </a>
                </h4>
            </div>

            <div id="task-details-general" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="task-details-general-heading">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <label class="control-label">Name:</label>
                        </div>

                        <div class="col-lg-8">
                            <span id="task-details-name"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <label class="control-label" id="loading-time-label">Loading time:</label>
                        </div>

                        <div class="col-lg-8">
                            <span id="task-details-loading-time"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <label class="control-label">Notes:</label>
                        </div>

                        <div class="col-lg-8">
                            <p id="task-details-notes"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="task-details-from-to-heading">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#task-details-accordion" href="#task-details-from-to" aria-expanded="false" aria-controls="task-details-from-to">
                        Address & Time
                    </a>
                </h4>
            </div>

            <div id="task-details-from-to" class="panel-collapse collapse" role="tabpanel" aria-labelledby="task-details-from-to-heading">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <label class="control-label">From address:</label>
                        </div>

                        <div class="col-lg-8">
                            <span id="task-details-from-address"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <label class="control-label">From city:</label>
                        </div>

                        <div class="col-lg-8">
                            <span id="task-details-from-city"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <label class="control-label">Pickup from:</label>
                        </div>

                        <div class="col-lg-8">
                            <span id="task-details-pickup-from"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <label class="control-label">Pickup to:</label>
                        </div>

                        <div class="col-lg-8">
                            <span id="task-details-pickup-to"></span>
                        </div>
                    </div>

                    <div class="row" id="task-details-to-address-row">
                        <div class="col-lg-4">
                            <label class="control-label">To address:</label>
                        </div>

                        <div class="col-lg-8">
                            <span id="task-details-to-address"></span>
                        </div>
                    </div>

                    <div class="row" id="task-details-to-city-row">
                        <div class="col-lg-4">
                            <label class="control-label">To city:</label>
                        </div>

                        <div class="col-lg-8">
                            <span id="task-details-to-city"></span>
                        </div>
                    </div>

                    <div class="row" id="task-details-delivery-from-row">
                        <div class="col-lg-4">
                            <label class="control-label">Delivery from:</label>
                        </div>

                        <div class="col-lg-8">
                            <span id="task-details-delivery-from"></span>
                        </div>
                    </div>

                    <div class="row" id="task-details-delivery-to-row">
                        <div class="col-lg-4">
                            <label class="control-label">Delivery to:</label>
                        </div>

                        <div class="col-lg-8">
                            <span id="task-details-delivery-to"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="task-details-passengers-heading">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#task-details-accordion" href="#task-details-passengers" aria-expanded="false" aria-controls="task-details-passengers">
                        Passengers
                    </a>
                </h4>
            </div>

            <div id="task-details-passengers" class="panel-collapse collapse" role="tabpanel" aria-labelledby="task-details-passengers-heading">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <label class="control-label">Passengers:</label>
                        </div>

                        <div class="col-lg-8">
                            <span id="task-details-total-passengers"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="task-details-cargo-heading">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#task-details-accordion" href="#task-details-cargo" aria-expanded="false" aria-controls="task-details-cargo">
                        Cargo
                    </a>
                </h4>
            </div>

            <div id="task-details-cargo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="task-details-cargo-heading">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <label class="control-label">Total volume:</label>
                        </div>

                        <div class="col-lg-4">
                            <span id="task-details-total-volume"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8">
                            <label class="control-label">Total weight:</label>
                        </div>

                        <div class="col-lg-4">
                            <span id="task-details-max-weight"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8">
                            <label class="control-label">Weather protection:</label>
                        </div>

                        <div class="col-lg-4">
                            <span id="task-details-weather-protection"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8">
                            <label class="control-label">Fragile:</label>
                        </div>

                        <div class="col-lg-4">
                            <span id="task-details-fragile"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8">
                            <label class="control-label">Food:</label>
                        </div>

                        <div class="col-lg-4">
                            <span id="task-details-food"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8">
                            <label class="control-label">Crane:</label>
                        </div>

                        <div class="col-lg-4">
                            <span id="task-details-crane"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8">
                            <label class="control-label">Rear lift:</label>
                        </div>

                        <div class="col-lg-4">
                            <span id="task-details-rear-lift"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8">
                            <label class="control-label">Temperature control:</label>
                        </div>

                        <div class="col-lg-4">
                            <span id="task-details-temp-control"></span>
                        </div>
                    </div>

                    <div class="row" id="view-task-min-temperature-value">
                        <div class="col-lg-8">
                            <label class="control-label">Min temperature:</label>
                        </div>

                        <div class="col-lg-4">
                            <span id="task-details-min-temp"></span>
                        </div>
                    </div>

                    <div class="row" id="view-task-max-temperature-value">
                        <div class="col-lg-8">
                            <label class="control-label">Max temperature:</label>
                        </div>

                        <div class="col-lg-4">
                            <span id="task-details-max-temp"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>