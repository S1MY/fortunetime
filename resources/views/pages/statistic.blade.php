@extends('../master')

@section('title', 'Статистика')

@section('content')
    <section class="pageSection">
        <div class="container">
            <div class="pageInner">
                <h1 class="pageName center">Статистика</h1>
                <div class="pageFlex displayFlex spaceBetween statisticFlex">
                    <div class="statPageItem">
                        <div class="statPageTable">
                            <p class="pageTableTop">Последние начисления</p>
                            <div class="pageTableItem">
                                <div class="pageTableItemL">
                                    <div class="pageUserAvatar"></div>
                                    <div class="pageTableItemInfo">
                                        <p class="pageTableUsername">Алексашка</p>
                                        <p class="pageTableDate">11 мая в 12:55</p>
                                    </div>
                                </div>
                                <div class="pageTableItemR">
                                    <p class="pageTableNumb">Начисление М#1</p>
                                    <p class="pageTableCount">+650 РУБ</p>
                                </div>
                            </div>
                            <div class="pageTableItem">
                                <div class="pageTableItemL">
                                    <div class="pageUserAvatar"></div>
                                    <div class="pageTableItemInfo">
                                        <p class="pageTableUsername">Алексашка</p>
                                        <p class="pageTableDate">11 мая в 12:55</p>
                                    </div>
                                </div>
                                <div class="pageTableItemR">
                                    <p class="pageTableNumb">Начисление М#1</p>
                                    <p class="pageTableCount">+650 РУБ</p>
                                </div>
                            </div>
                            <div class="pageTableItem">
                                <div class="pageTableItemL">
                                    <div class="pageUserAvatar"></div>
                                    <div class="pageTableItemInfo">
                                        <p class="pageTableUsername">Алексашка</p>
                                        <p class="pageTableDate">11 мая в 12:55</p>
                                    </div>
                                </div>
                                <div class="pageTableItemR">
                                    <p class="pageTableNumb">Начисление М#1</p>
                                    <p class="pageTableCount">+650 РУБ</p>
                                </div>
                            </div>
                            <div class="pageTableItem">
                                <div class="pageTableItemL">
                                    <div class="pageUserAvatar"></div>
                                    <div class="pageTableItemInfo">
                                        <p class="pageTableUsername">Алексашка</p>
                                        <p class="pageTableDate">11 мая в 12:55</p>
                                    </div>
                                </div>
                                <div class="pageTableItemR">
                                    <p class="pageTableNumb">Начисление М#1</p>
                                    <p class="pageTableCount">+650 РУБ</p>
                                </div>
                            </div>
                            <div class="pageTableItem">
                                <div class="pageTableItemL">
                                    <div class="pageUserAvatar"></div>
                                    <div class="pageTableItemInfo">
                                        <p class="pageTableUsername">Алексашка</p>
                                        <p class="pageTableDate">11 мая в 12:55</p>
                                    </div>
                                </div>
                                <div class="pageTableItemR">
                                    <p class="pageTableNumb">Начисление М#1</p>
                                    <p class="pageTableCount">+650 РУБ</p>
                                </div>
                            </div>
                        </div>
                        <div class="paginationWrapper displayFlex alignItemsCenter spaceCenter">
                            <button class="prev displayFlex alignItemsCenter spaceCenter disabledPag">
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.7665 15.9839L21.4901 23.3951C21.6445 23.53 21.7691 23.6932 21.8565 23.8751C21.9439 24.057 21.9925 24.2539 21.9992 24.4541C22.0059 24.6544 21.9707 24.8538 21.8957 25.0408C21.8206 25.2277 21.7072 25.3983 21.5622 25.5424C21.4172 25.6866 21.2436 25.8013 21.0516 25.8799C20.8595 25.9585 20.653 25.9993 20.4442 26C20.2355 26.0006 20.0287 25.9611 19.8361 25.8837C19.6436 25.8063 19.4691 25.6926 19.3232 25.5493L19.2852 25.5128L10.457 17.0438C10.1644 16.763 10 16.3821 10 15.9849C10 15.5878 10.1644 15.2069 10.457 14.9261L19.2831 6.45706C19.4255 6.31561 19.5955 6.20247 19.7835 6.12408C19.9715 6.0457 20.1738 6.00361 20.3787 6.00022C20.5837 5.99683 20.7873 6.03221 20.978 6.10434C21.1687 6.17647 21.3427 6.28393 21.4901 6.42059C21.6375 6.55724 21.7554 6.72042 21.8371 6.90081C21.9188 7.0812 21.9627 7.27526 21.9662 7.47191C21.9697 7.66856 21.9329 7.86396 21.8577 8.04693C21.7825 8.22991 21.6705 8.39689 21.5281 8.53834L21.4901 8.57482L13.7665 15.9839Z" fill="#202020" />
                                </svg>
                            </button>
                            <button id="1" class="active">1</button>
                            <button class="link" data-href="">2</button>
                            <button class="link" data-href="">3</button>
                            <button class="next displayFlex alignItemsCenter spaceCenter link" data-href="">
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M18.2335 16.0161L10.5099 8.60493C10.3555 8.47004 10.2309 8.30681 10.1435 8.1249C10.0561 7.94299 10.0075 7.7461 10.0008 7.54588C9.99408 7.34565 10.0293 7.14616 10.1043 6.95923C10.1794 6.77229 10.2928 6.60171 10.4378 6.45757C10.5828 6.31343 10.7564 6.19866 10.9484 6.12007C11.1405 6.04148 11.347 6.00065 11.5558 6.00001C11.7645 5.99937 11.9713 6.03892 12.1639 6.11633C12.3564 6.19375 12.5309 6.30744 12.6768 6.45069L12.7148 6.48717L21.543 14.9562C21.8356 15.237 22 15.6179 22 16.0151C22 16.4122 21.8356 16.7931 21.543 17.0739L12.7169 25.5429C12.5745 25.6844 12.4045 25.7975 12.2165 25.8759C12.0285 25.9543 11.8262 25.9964 11.6213 25.9998C11.4163 26.0032 11.2127 25.9678 11.022 25.8957C10.8313 25.8235 10.6573 25.7161 10.5099 25.5794C10.3625 25.4428 10.2446 25.2796 10.1629 25.0992C10.0812 24.9188 10.0373 24.7247 10.0338 24.5281C10.0303 24.3314 10.0671 24.136 10.1423 23.9531C10.2175 23.7701 10.3295 23.6031 10.4719 23.4617L10.5099 23.4252L18.2335 16.0161Z" fill="#202020" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="statPageItem">
                        <div class="statPageTable">
                            <p class="pageTableTop">Последние выплаты</p>
                            <div class="pageTableItem">
                                <div class="pageTableItemL">
                                    <div class="pageUserAvatar"></div>
                                    <div class="pageTableItemInfo">
                                        <p class="pageTableUsername">Алексашка</p>
                                        <p class="pageTableDate">11 мая в 12:55</p>
                                    </div>
                                </div>
                                <div class="pageTableItemR">
                                    <p class="pageTableNumb">Выплата #1</p>
                                    <p class="pageTableCount">+650 РУБ</p>
                                </div>
                            </div>
                            <div class="pageTableItem">
                                <div class="pageTableItemL">
                                    <div class="pageUserAvatar"></div>
                                    <div class="pageTableItemInfo">
                                        <p class="pageTableUsername">Алексашка</p>
                                        <p class="pageTableDate">11 мая в 12:55</p>
                                    </div>
                                </div>
                                <div class="pageTableItemR">
                                    <p class="pageTableNumb">Выплата #1</p>
                                    <p class="pageTableCount">+650 РУБ</p>
                                </div>
                            </div>
                            <div class="pageTableItem">
                                <div class="pageTableItemL">
                                    <div class="pageUserAvatar"></div>
                                    <div class="pageTableItemInfo">
                                        <p class="pageTableUsername">Алексашка</p>
                                        <p class="pageTableDate">11 мая в 12:55</p>
                                    </div>
                                </div>
                                <div class="pageTableItemR">
                                    <p class="pageTableNumb">Выплата #1</p>
                                    <p class="pageTableCount">+650 РУБ</p>
                                </div>
                            </div>
                            <div class="pageTableItem">
                                <div class="pageTableItemL">
                                    <div class="pageUserAvatar"></div>
                                    <div class="pageTableItemInfo">
                                        <p class="pageTableUsername">Алексашка</p>
                                        <p class="pageTableDate">11 мая в 12:55</p>
                                    </div>
                                </div>
                                <div class="pageTableItemR">
                                    <p class="pageTableNumb">Выплата #1</p>
                                    <p class="pageTableCount">+650 РУБ</p>
                                </div>
                            </div>
                            <div class="pageTableItem">
                                <div class="pageTableItemL">
                                    <div class="pageUserAvatar"></div>
                                    <div class="pageTableItemInfo">
                                        <p class="pageTableUsername">Алексашка</p>
                                        <p class="pageTableDate">11 мая в 12:55</p>
                                    </div>
                                </div>
                                <div class="pageTableItemR">
                                    <p class="pageTableNumb">Выплата #1</p>
                                    <p class="pageTableCount">+650 РУБ</p>
                                </div>
                            </div>
                        </div>
                        <div class="paginationWrapper displayFlex alignItemsCenter spaceCenter">
                            <button class="prev displayFlex alignItemsCenter spaceCenter disabledPag">
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.7665 15.9839L21.4901 23.3951C21.6445 23.53 21.7691 23.6932 21.8565 23.8751C21.9439 24.057 21.9925 24.2539 21.9992 24.4541C22.0059 24.6544 21.9707 24.8538 21.8957 25.0408C21.8206 25.2277 21.7072 25.3983 21.5622 25.5424C21.4172 25.6866 21.2436 25.8013 21.0516 25.8799C20.8595 25.9585 20.653 25.9993 20.4442 26C20.2355 26.0006 20.0287 25.9611 19.8361 25.8837C19.6436 25.8063 19.4691 25.6926 19.3232 25.5493L19.2852 25.5128L10.457 17.0438C10.1644 16.763 10 16.3821 10 15.9849C10 15.5878 10.1644 15.2069 10.457 14.9261L19.2831 6.45706C19.4255 6.31561 19.5955 6.20247 19.7835 6.12408C19.9715 6.0457 20.1738 6.00361 20.3787 6.00022C20.5837 5.99683 20.7873 6.03221 20.978 6.10434C21.1687 6.17647 21.3427 6.28393 21.4901 6.42059C21.6375 6.55724 21.7554 6.72042 21.8371 6.90081C21.9188 7.0812 21.9627 7.27526 21.9662 7.47191C21.9697 7.66856 21.9329 7.86396 21.8577 8.04693C21.7825 8.22991 21.6705 8.39689 21.5281 8.53834L21.4901 8.57482L13.7665 15.9839Z" fill="#202020" />
                                </svg>
                            </button>
                            <button id="1" class="active">1</button>
                            <button class="link" data-href="">2</button>
                            <button class="link" data-href="">3</button>
                            <button class="next displayFlex alignItemsCenter spaceCenter link" data-href="">
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M18.2335 16.0161L10.5099 8.60493C10.3555 8.47004 10.2309 8.30681 10.1435 8.1249C10.0561 7.94299 10.0075 7.7461 10.0008 7.54588C9.99408 7.34565 10.0293 7.14616 10.1043 6.95923C10.1794 6.77229 10.2928 6.60171 10.4378 6.45757C10.5828 6.31343 10.7564 6.19866 10.9484 6.12007C11.1405 6.04148 11.347 6.00065 11.5558 6.00001C11.7645 5.99937 11.9713 6.03892 12.1639 6.11633C12.3564 6.19375 12.5309 6.30744 12.6768 6.45069L12.7148 6.48717L21.543 14.9562C21.8356 15.237 22 15.6179 22 16.0151C22 16.4122 21.8356 16.7931 21.543 17.0739L12.7169 25.5429C12.5745 25.6844 12.4045 25.7975 12.2165 25.8759C12.0285 25.9543 11.8262 25.9964 11.6213 25.9998C11.4163 26.0032 11.2127 25.9678 11.022 25.8957C10.8313 25.8235 10.6573 25.7161 10.5099 25.5794C10.3625 25.4428 10.2446 25.2796 10.1629 25.0992C10.0812 24.9188 10.0373 24.7247 10.0338 24.5281C10.0303 24.3314 10.0671 24.136 10.1423 23.9531C10.2175 23.7701 10.3295 23.6031 10.4719 23.4617L10.5099 23.4252L18.2335 16.0161Z" fill="#202020" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
