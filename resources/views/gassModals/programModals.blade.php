<!-- Edit GASS Modal -->
<div class="modal fade" id="editGassModal" data-bs-backdrop="static" aria-hidden="true" tabindex="-1" aria-labelledby="editGassModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-xl" style="display: flex; align-items: center; margin: 1.75rem auto;">
        <div class="modal-content border-0 shadow rounded-3">
            <!-- Header -->
            <div class="modal-header border-0 rounded-top" style="background-color: #03592c;">
                <h5 class="modal-title text-white fw-bold" id="editGassModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit GASS
                </h5>
            </div>

            <!-- Body -->
            <div class="modal-body" style="background-color: #ffffff;">
                <form id="editGassForm" class="p-2">
                    @csrf
                    <input type="hidden" id="editGassId" name="editGassId" required>

                    <div class="mb-3">
                        <textarea class="form-control border-2 py-2 fw-bold text-uppercase"
                            style="border-color: #03592c; min-height: 50px; resize: vertical;"
                            name="editGassName" id="editGassName" disabled></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark mb-0">Allotted Budget:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; min-height: 50px; resize: vertical;"
                            name="editGassBudget" id="editGassBudget"></textarea>
                    </div>

                    <!-- Footer -->
                    <div class="modal-footer border-0 mt-3" style="background-color: #f8f9fa;">
                        <button type="button" class="btn btn-danger px-3 closeEditModal">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-success px-3">
                            <i class="fas fa-save me-2"></i>Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add GASS Program Modal -->
<div class="modal fade" id="addGassProgramModal" data-bs-backdrop="static" aria-hidden="true" tabindex="-1" aria-labelledby="addGassProgramModal">
    <div class="modal-dialog modal-dialog-centered modal-xl" style="display: flex; align-items: center; margin: 1.75rem auto;">
        <div class="modal-content border-0 shadow rounded-3">
            <!-- Header -->
            <div class="modal-header border-0 rounded-top" style="background-color: #03592c;">
                <h5 class="modal-title text-white fw-bold" id="addGassProgramModal">
                    <i class="fas fa-edit me-2"></i>Add Program under GASS
                </h5>
            </div>

            <!-- Body -->
            <div class="modal-body" style="background-color: #ffffff;">
                <form id="addGassProgramForm" class="p-2">
                    @csrf

                    <!-- Division Responsible -->
                    <div class="mb-3">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <label class="form-label fw-bold text-dark mb-0">Division/s Responsible:</label>
                            <button class="btn btn-sm text-white buttonHover" id="addGassDivisionBtn" title="Add division responsible" style="background-color: #01a550;">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <div id="gassDivisionSelectContainer" data-gass-divisions="{{ json_encode($divisions) }}">
                            <div class="division-select-group mb-2 d-flex gap-2 align-items-center">
                                <select class="form-select border border-success selectDivision" name="divisions[]">
                                    @foreach ($divisions as $division)
                                        <option value="{{ $division->id }}">{{ $division->name }}</option>
                                    @endforeach
                                    <option value="all">All Divisions</option>
                                </select>
                                <button type="button" class="btn btn-danger btn-sm removeDivisionBtn" disabled>
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center border-success">
                            <thead class="table-light fw-bold text-dark">
                                <tr>
                                    <th style="min-width: 200px;">Programs/Project/Activities</th>
                                    <th style="min-width: 200px;">Success Indicator</th>
                                    <th style="min-width: 200px;">Quality</th>
                                    <th style="min-width: 200px;">Efficiency</th>
                                    <th style="min-width: 200px;">Timeliness</th>
                                    <th style="min-width: 200px;">Remarks</th>
                                    <th style="min-width: 200px;">Allotted Budget</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize"
                                            style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addProgramName" id="addProgramName" autofocus></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize"
                                            style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addSuccessIndicator" id="addSuccessIndicator"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize"
                                            style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addQuality" id="addQuality"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize"
                                            style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addEfficiency" id="addEfficiency"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize"
                                            style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addTimeliness" id="addTimeliness"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize"
                                            style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addRemarks" id="addRemarks"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize"
                                            style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="addBudget" id="addBudget"></textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Footer -->
                    <div class="modal-footer border-0 mt-3" style="background-color: #f8f9fa;">
                        <button type="button" class="btn btn-danger px-3 closeAddModal">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-success px-3">
                            <i class="fas fa-save me-2"></i>Save Program
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit GASS Program Modal -->
<div class="modal fade" id="editGassProgramModal" data-bs-backdrop="static" aria-hidden="true" tabindex="-1" aria-labelledby="editGassProgramModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-xl" style="display: flex; align-items: center; margin: 1.75rem auto;">
        <div class="modal-content border-0 shadow rounded-3">
            <!-- Header -->
            <div class="modal-header border-0 rounded-top" style="background-color: #03592c;">
                <h5 class="modal-title text-white fw-bold" id="editGassProgramModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Program under GASS
                </h5>
            </div>

            <!-- Body -->
            <div class="modal-body" style="background-color: #ffffff;">
                <form id="editGassProgramForm" class="p-2">
                    @csrf
                    <input type="hidden" id="editGassProgramId" name="editGassProgramId" required>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark mb-1">Program Name:</label>
                        <textarea class="form-control border-2 py-2"
                            style="border-color: #03592c; min-height: 50px; resize: vertical;"
                            name="editGassProgramName" id="editGassProgramName" required></textarea>
                    </div>

                    <!-- Division Responsible -->
                    <div class="mb-3">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <label class="form-label fw-bold text-dark mb-0">Division/s Responsible:</label>
                            <button class="btn btn-sm text-white" id="editAddDivisionBtn" type="button" title="Add division responsible" style="background-color: #01a550;">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>

                        <div id="editGassDivisionSelectContainer" data-divisions="{{ json_encode($divisions) }}">
                            <div class="division-select-group mb-2 d-flex gap-2 align-items-center">
                                <select class="form-select border border-success" name="divisions[]">
                                    @foreach ($divisions as $division)
                                        <option value="{{ $division->id }}">{{ $division->name }}</option>
                                    @endforeach
                                    <option value="all">All Divisions</option>
                                </select>
                                <button type="button" class="btn btn-danger btn-sm removeDivisionBtn" disabled>
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center border-success">
                            <thead class="table-light fw-bold text-dark">
                                <tr>
                                    <th style="min-width: 200px;">Success Indicator</th>
                                    <th style="min-width: 200px;">Quality</th>
                                    <th style="min-width: 200px;">Efficiency</th>
                                    <th style="min-width: 200px;">Timeliness</th>
                                    <th style="min-width: 200px;">Remarks</th>
                                    <th style="min-width: 200px;">Budget</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize" style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="editGassProgramSuccessIndicator" id="editGassProgramSuccessIndicator"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize" style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="editGassProgramQuality" id="editGassProgramQuality"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize" style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="editGassProgramEfficiency" id="editGassProgramEfficiency"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize" style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="editGassProgramTimeliness" id="editGassProgramTimeliness"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: top;">
                                        <textarea class="form-control border-0 shadow-none auto-resize" style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="editGassProgramRemarks" id="editGassProgramRemarks"></textarea>
                                    </td>
                                    <td style="border: 1px solid #ccc; vertical-align: middle;">
                                        <textarea class="form-control border-0 shadow-none auto-resize text-center" style="display: block; margin: auto 0; width: 100%; padding-top: 5px;" name="editGassProgramBudget" id="editGassProgramBudget"></textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Footer -->
                    <div class="modal-footer border-0 mt-3" style="background-color: #f8f9fa;">
                        <button type="button" class="btn btn-danger px-3 closeEditModal">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-success px-3">
                            <i class="fas fa-save me-2"></i>Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>