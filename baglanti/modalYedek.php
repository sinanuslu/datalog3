<!-- Modal: METODOLOJİ -->
<div class="modal fade" id="modalMetodoloji' . htmlspecialchars($value["calisma_id"]) . '" tabindex="-1" aria-labelledby="modalMetodolojiLabel' . htmlspecialchars($value["calisma_id"]) . '" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalMetodolojiLabel' . htmlspecialchars($value["calisma_id"]) . '">METODOLOJİ</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" style="font-size: 0.75rem; overflow-x:hidden;">
                                ' . $highlightedMetaVeri['highlightedText'][$value['calisma_id']][0] . '
                            </div>
                        </div>
                    </div>
                </div>


                                <!-- Modal: SORULAR -->
                                <div class="modal fade" id="modalSorular' . htmlspecialchars($value["calisma_id"]) . '" tabindex="-1" aria-labelledby="modalSorularLabel' . htmlspecialchars($value["calisma_id"]) . '" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalSorularLabel' . htmlspecialchars($value["calisma_id"]) . '">SORU / CEVAP</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" style="font-size: 0.75rem; padding:0; margin:16px; overflow-x:hidden;">
                            <div id="infoDiv"></div>
                            <table class="table table-striped-columns" style="width: 100%;">
                            <thead><tr>
                            <th scope="col" style="width: 4%;">Soru ID</th>
                            <th scope="col" style="width: 48%;">Soru</th>
                            <th scope="col" style="width: 48%;">Cevap</th>
                            </tr></thead>';
                foreach ($highlightedSoru['highlightedText'][$value['calisma_id']] as $key => $soru) {
                    $cevap = $highlightedCevap['highlightedText'][$value['calisma_id']][$key];
                    $output .=  '<tr>
                                    <th scope="row">' . $key . '</th>
                                    <td><div class="tips">' . $soru . '</div>
                                        <span>' . $soru . '</span>
                                    </td>
                                    <td><div class="tips">' . $cevap . '</div>
                                        <span>';
                    if ($cevap == "[]") {
                        $output .= 'Açık Uçlu';
                    } else {
                        $output .= $cevap .
                            '</span>';
                    }
                    $output .=
                        '</td>
                                </tr>';
                }
                $output .= '</table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal: CEVAPLAR -->
                <div class="modal fade" id="modalCevaplar' . htmlspecialchars($value["calisma_id"]) . '" tabindex="-1" aria-labelledby="modalCevaplarLabel' . htmlspecialchars($value["calisma_id"]) . '" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalCevaplarLabel' . htmlspecialchars($value["calisma_id"]) . '">DÖKÜMAN</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" style="font-size: 0.75rem; overflow-x:hidden;">';
                //Döküman ve dashboard bağlantıları
                $files = getDocs($value["calisma_id"]);
                foreach ($files as $file) {
                    $output .= '<a href="downDocs.php?path=' . $file . '"><span class="badge text-bg-secondary m-1 p-2 fs-6">' . basename($file) . '</span></a>';
                }
                $output .= '
                            </div>
                        </div>
                    </div>
                </div>