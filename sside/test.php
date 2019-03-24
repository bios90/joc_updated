<div id="modal_edit_drink" class="modal fade" tabindex="-1" role="dialog" aria-labelledby=""
     aria-hidden="true">
    <div id="modal_edit_drink_div" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">


            <form action="/" method="post" id="form_edit_drink" enctype="multipart/form-data" data-product-id="">

                <div class="modal-header">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="text-center modal_title">Редактирование продукта</h4>
                                <p class="text-center modal_subtitle">Измените параметры уже добавленного продукта.</p>
                            </div>
                        </div>
                    </div>
                    <i class="fas fa-times my_modal_close" data-dismiss="modal" aria-label="Close"></i>
                </div>


                <div class="modal-body">
                    <div id="add_drink_inputs_container_edit" class="container">

                        <div id="name_row_edit" class="row input_row mt-4">

                            <div class="col-sm-12 col-lg-3 text-center">
                                <label class="my_modal_label" for="name">Название</label>
                            </div>

                            <div class="col-sm-12 col-lg-6 text-center">
                                <input type="text" class="form-control my_input" id="name_edit" name="name">
                            </div>

                            <div id="err_div_name_edit" class="col-sm-12 col-lg-3 invisible err_div">
                                <i class="fas fa-exclamation-circle error_icon pt-2"></i>
                                <p class="input_error"></p>
                            </div>

                        </div>


                        <div id="categ_row_edit" class="row input_row mt-4">

                            <div class="col-sm-12 col-lg-3 text-center">
                                <label class="my_modal_label" for="categ">Категория</label>
                            </div>

                            <div id="input_categ_col_edit" class="col-sm-12 col-lg-6 text-center position-relative">
                                <select id="select_categ_edit" class="custom-select mr-sm-2" name="categ">
                                    <option class="my_option" value="0">Горячие Напитки</option>
                                    <option class="my_option" value="1">Холодные Напитки</option>
                                </select>

                                <p id="par_arrow_edit" class="d-inline-block position-absolute">▾</p>
                            </div>

                        </div>


                        <div id="desc_row_edit" class="row input_row mt-4">

                            <div class="col-sm-12 col-lg-3 text-center">
                                <label class="my_modal_label" for="desc">Описание</label>
                            </div>

                            <div class="col-sm-12 col-lg-6 text-center">
                                <textarea rows="3" type="text" class="form-control my_input" id="description_edit"
                                          name="description"></textarea>
                            </div>

                            <div id="err_div_description_edit" class="col-sm-12 col-lg-3 invisible err_div">
                                <i class="fas fa-exclamation-circle error_icon pt-2"></i>
                                <p class="input_error"></p>
                            </div>

                        </div>


                        <div class="row input_row">
                            <div class="col-sm-12 col-lg-3 text-center">
                                <label class="my_modal_label" for="reg_cafe_inn">Изображение</label>
                            </div>
                            <div class="col-sm-12 col-lg-6 text-center">

                                <div id="file_input_div_edit" class="form-control" style="float: left">
                                    <p id="icon_upload_edit">
                                        <i id="upd_edit" class="fas fa-upload"></i>
                                        <img id="logo_logo_edit" class="invisible" src="" alt="">
                                    </p>
                                    <input type="file" class="form-control my_input" id="img_product_edit"
                                           name="img_product">
                                </div>

                                <small id="logo_small_edit" class="form-text ">Изображение продукта. Файлы изображение
                                    Jpeg/Png до 5 мб.
                                </small>

                                <p id="current_logo_name_edit"></p>

                            </div>
                            <div id="err_div_logo_edit" class="col-sm-12 col-lg-3 invisible err_div">
                                <i class="fas fa-exclamation-circle error_icon"></i>
                                <p class="input_error"></p>
                            </div>
                        </div>


                        <div id="weight_row_edit" class="row input_row mt-4">

                            <div class="col-sm-12 col-lg-3 text-center">
                                <label class="my_modal_label" for="">Объем</label>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <div id="div_for_weights_edit" class="d-inline-block w-100">

                                </div>

                                <div>
                                    <small class="third-small">Объем</small>
                                    <small class="third-small third-center">Цена</small>
                                    <small class="third-small"></small>
                                    <input id="inp_weight_weight_edit" type="text" class="form-control my_input third"
                                           name="weight_weight">
                                    <input id="inp_weight_price_edit" type="text"
                                           class="form-control my_input third third-center"
                                           name="weight_price">
                                    <button id="btn_add_weight_edit" class="btn_add" type="button" id="inp_weight_edit"
                                            name="name">
                                        Добавить
                                    </button>
                                </div>
                            </div>


                            <div id="err_div_weight_edit" class="col-sm-12 col-lg-3 invisible err_div pt-2">
                                <i class="fas pt-2 fa-exclamation-circle error_icon"></i>
                                <p class="input_error"></p>
                            </div>

                        </div>


                        <div id="add_row_edit" class="row input_row mt-4">

                            <div class="col-sm-12 col-lg-3 text-center">
                                <label class="my_modal_label" for="">Добавки</label>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <div id="div_for_adds_edit" class="d-inline-block w-100">


                                </div>

                                <div>
                                    <small class="third-small">Название</small>
                                    <small class="third-small third-center">Цена</small>
                                    <small class="third-small"></small>
                                    <input type="text" class="form-control my_input third" id="inp_add_name_edit"
                                           name="add_name">
                                    <input type="text" class="form-control my_input third third-center"
                                           id="inp_add_price_edit" name="add_price">
                                    <button id="btn_add_add_edit" class="btn_add" type="button" name="name"
                                    >Добавить
                                    </button>
                                </div>
                            </div>


                            <div id="err_div_add_edit" class="col-sm-12 col-lg-3 invisible err_div pt-2">
                                <i class="fas pt-2 fa-exclamation-circle error_icon"></i>
                                <p class="input_error"></p>
                            </div>

                        </div>


                        <!--           ============================             -->


                        <div id="milk_row_edit" class="row input_row mt-4">

                            <div class="col-sm-12 col-lg-3 text-center">
                                <label class="my_modal_label" for="">Молоко</label>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <div id="div_for_milks_edit" class="d-inline-block w-100">

                                </div>

                                <div>
                                    <small class="third-small">Название</small>
                                    <small class="third-small third-center">Цена</small>
                                    <small class="third-small"></small>
                                    <input id="inp_milk_name_edit" type="text" class="form-control my_input third"
                                           name="milk_name">
                                    <input id="inp_milk_price_edit" name="add_price" type="text"
                                           class="form-control my_input third third-center">
                                    <button id="btn_add_milk_edit" class="btn_add" type="button" name="name"
                                    >Добавить
                                    </button>
                                </div>
                            </div>


                            <div id="err_div_milk_edit" class="col-sm-12 col-lg-3 invisible err_div pt-2">
                                <i class="fas pt-2 fa-exclamation-circle error_icon"></i>
                                <p class="input_error"></p>
                            </div>

                        </div>


                    </div>
                </div>


                <div class="modal-footer">

                    <div class="container">
                        <div class="row">

                            <div class="col-sm-12 col-md-4 offset-md-4 pb-4 pt-4">
                                <input type="submit" class="mybtn w-100 mt-0 mb-0" href="" value="Добавить">
                            </div>

                        </div>
                    </div>

                </div>

            </form>
        </div>
    </div>
</div>