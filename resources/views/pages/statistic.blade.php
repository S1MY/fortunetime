@extends('../master')

@section('title', 'Контакты')

@section('content')
    <section class="contactSection">
        <div class="container">
            <div class="contactInner displayFlex alignEnd spaceBetween">
                <form class="contactInnerL AJAXForm" id="aboutForm" method="POST" action="{{ route('send') }}">
                    <div class="contactTitle displayFlex alignItemsCenter spaceBetween">
                        <h1 class="pageName">Контакты</h1>
                        <div class="contactFlex displayFlex alignItemsCenter">
                            <a href="" class="contactLink">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_46_1153)">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M23.45 5.948C23.616 5.402 23.45 5 22.655 5H20.03C19.362 5 19.054 5.347 18.887 5.73C18.887 5.73 17.552 8.926 15.661 11.002C15.049 11.604 14.771 11.795 14.437 11.795C14.27 11.795 14.019 11.604 14.019 11.057V5.948C14.019 5.292 13.835 5 13.279 5H9.151C8.734 5 8.483 5.304 8.483 5.593C8.483 6.214 9.429 6.358 9.526 8.106V11.904C9.526 12.737 9.373 12.888 9.039 12.888C8.149 12.888 5.984 9.677 4.699 6.003C4.45 5.288 4.198 5 3.527 5H0.9C0.15 5 0 5.347 0 5.73C0 6.412 0.89 9.8 4.145 14.281C6.315 17.341 9.37 19 12.153 19C13.822 19 14.028 18.632 14.028 17.997V15.684C14.028 14.947 14.186 14.8 14.715 14.8C15.105 14.8 15.772 14.992 17.33 16.467C19.11 18.216 19.403 19 20.405 19H23.03C23.78 19 24.156 18.632 23.94 17.904C23.702 17.18 22.852 16.129 21.725 14.882C21.113 14.172 20.195 13.407 19.916 13.024C19.527 12.533 19.638 12.314 19.916 11.877C19.916 11.877 23.116 7.451 23.449 5.948H23.45Z" fill="#4168D2"/>
                                    </g>
                                    <defs>
                                    <clipPath id="clip0_46_1153">
                                    <rect width="24" height="24" fill="white"/>
                                    </clipPath>
                                    </defs>
                                </svg>
                            </a>
                            <a href="" class="contactLink">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20.7097 3.65451C20.7097 3.65451 22.6522 2.89701 22.4897 4.73651C22.4362 5.49401 21.9507 8.14551 21.5727 11.013L20.2777 19.508C20.2777 19.508 20.1697 20.7525 19.1982 20.969C18.2272 21.185 16.7702 20.2115 16.5002 19.995C16.2842 19.8325 12.4532 17.3975 11.1042 16.2075C10.7262 15.8825 10.2942 15.2335 11.1582 14.476L16.8237 9.06501C17.4712 8.41601 18.1187 6.90101 15.4207 8.74051L7.86567 13.8805C7.86567 13.8805 7.00217 14.422 5.38367 13.935L1.87567 12.8525C1.87567 12.8525 0.58067 12.041 2.79317 11.2295C8.18967 8.68651 14.8272 6.08951 20.7087 3.65451H20.7097Z" fill="#4168D2"/>
                                </svg>
                            </a>
                            <a href="" class="contactLink">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.9241 11.7996L11.2289 10.542C10.9937 10.4328 10.8005 10.5552 10.8005 10.8156V13.1844C10.8005 13.4448 10.9937 13.5672 11.2289 13.458L13.9229 12.2004C14.1593 12.09 14.1593 11.91 13.9241 11.7996ZM12.0005 0.47998C5.63807 0.47998 0.480469 5.63758 0.480469 12C0.480469 18.3624 5.63807 23.52 12.0005 23.52C18.3629 23.52 23.5205 18.3624 23.5205 12C23.5205 5.63758 18.3629 0.47998 12.0005 0.47998ZM12.0005 16.68C6.10367 16.68 6.00047 16.1484 6.00047 12C6.00047 7.85158 6.10367 7.31998 12.0005 7.31998C17.8973 7.31998 18.0005 7.85158 18.0005 12C18.0005 16.1484 17.8973 16.68 12.0005 16.68Z" fill="#4168D2"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="sendMailWrapper">
                        <p class="contactText">Уважаемый пользователь! Вы можете задать любой вопрос, заполнив форму обратной связи.</p>
                        <div class="inputFlex displayFlex alignItemsCenter spaceBetween">
                            @csrf
                            <input type="text" class="formInput" placeholder="Ваше Имя" name="name">
                            <input type="email" class="formInput" placeholder="Ваш E-Mail" name="email">
                        </div>
                        <textarea class="contactArea" placeholder="Ваш вопрос" name="question"></textarea>
                        <button class="standartBtn">Задать вопрос</button>
                    </div>
                </form>
                <svg width="500" height="300" viewBox="0 0 506 304" fill="none" xmlns="http://www.w3.org/2000/svg" class="contactInnerR">
                    <g clip-path="url(#clip0_46_1104)">
                    <path d="M344.241 173.546L348.58 172.797C348.996 172.724 349.409 172.636 349.825 172.561C342.958 168.308 337.744 161.851 335.042 154.25C332.34 146.65 332.308 138.359 334.953 130.739C337.6 123.119 342.764 116.624 349.599 112.319C356.435 108.015 364.534 106.159 372.567 107.055L366.88 120.556L380.353 108.819C380.385 108.826 380.416 108.836 380.446 108.849C384.858 110.399 388.921 112.801 392.402 115.919C395.884 119.036 398.716 122.806 400.736 127.014C402.757 131.224 403.927 135.789 404.18 140.449C404.433 145.109 403.762 149.773 402.208 154.174C401.983 154.815 401.715 155.426 401.458 156.045C405.261 154.138 408.91 151.918 411.886 149.076C417.909 143.316 421.211 135.369 424.899 125.577C432.206 106.174 439.242 86.4897 445.997 66.7624C438.546 62.7402 432.778 56.1995 429.727 48.3152C426.676 40.4309 426.544 31.7196 429.351 23.7461C429.714 22.7203 430.133 21.7325 430.577 20.7624C430.688 20.5196 430.801 20.2784 430.917 20.039C431.368 19.109 431.845 18.1977 432.368 17.323C432.454 17.1797 432.549 17.0455 432.637 16.9037C433.092 16.1663 433.572 15.4508 434.078 14.757C434.266 14.4965 434.454 14.2368 434.648 13.9825C435.22 13.2355 435.813 12.5086 436.439 11.8147C436.647 11.5825 436.87 11.3655 437.084 11.1394C437.564 10.6337 438.058 10.1433 438.564 9.66811C438.832 9.41795 439.096 9.16599 439.37 8.92471C439.441 8.8628 439.507 8.79523 439.577 8.73384C439.58 8.73837 439.583 8.74323 439.586 8.7477C445.86 3.29285 453.852 0.203738 462.173 0.0172647C470.492 -0.169209 478.615 2.55874 485.128 7.727L477.728 25.2961L491.048 13.6983C495.71 19.6237 498.352 26.8802 498.588 34.4092C498.826 41.9382 496.645 49.3457 492.365 55.5512C492.377 55.5555 492.39 55.5589 492.402 55.5632C492.257 55.7764 492.091 55.9716 491.942 56.1811C491.661 56.5742 491.373 56.9603 491.079 57.3394C490.7 57.8256 490.308 58.2955 489.907 58.7589C489.604 59.1088 489.305 59.4615 488.99 59.798C488.528 60.2902 488.045 60.7563 487.558 61.2199C487.275 61.4903 487.003 61.7743 486.711 62.0348C485.945 62.7171 485.154 63.3646 484.335 63.9771C484.048 64.1917 483.745 64.381 483.452 64.5864C482.877 64.9898 482.299 65.3872 481.703 65.7554C481.332 65.9836 480.952 66.1924 480.574 66.4069C480.027 66.7179 479.476 67.0191 478.913 67.3005C478.515 67.5 478.113 67.6894 477.707 67.8739C477.129 68.1366 476.545 68.3802 475.953 68.612C475.557 68.7674 475.162 68.9248 474.76 69.066C474.096 69.2992 473.424 69.5017 472.746 69.6957C472.405 69.7936 472.068 69.9057 471.723 69.9935C470.708 70.252 469.681 70.472 468.641 70.6406C468.446 70.6724 468.247 70.6844 468.051 70.7129C467.189 70.8379 466.324 70.9388 465.451 71.0004C465.075 71.0268 464.699 71.0306 464.322 71.0453C463.616 71.0726 462.91 71.0866 462.2 71.0714C461.786 71.0627 461.372 71.0413 460.957 71.018C460.266 70.9789 459.573 70.9188 458.881 70.8377C458.471 70.7905 458.063 70.7435 457.653 70.6816C456.911 70.5692 456.17 70.4223 455.428 70.2614C455.379 70.2509 455.331 70.2446 455.282 70.2338C452.431 78.5564 449.528 86.8613 446.57 95.1482C450.177 91.9131 454.408 89.4473 459.003 87.902C463.599 86.3568 468.462 85.7647 473.295 86.1622C478.128 86.5597 482.829 87.9383 487.109 90.2134C491.389 92.4886 495.157 95.6123 498.184 99.3929L485.87 112.98L502.542 106.339C506.592 114.813 507.106 124.543 503.968 133.392C502.881 136.502 501.358 139.443 499.443 142.126C495.324 147.94 489.548 152.384 482.866 154.882C476.184 157.381 468.904 157.819 461.97 156.139C455.035 154.459 448.766 150.74 443.977 145.461C439.187 140.183 436.098 133.592 435.109 126.541C434.796 127.376 434.493 128.221 434.179 129.056C430.924 137.694 426.875 148.444 418.742 156.217C413.23 161.485 406.447 164.827 399.941 167.652C395.703 169.493 391.409 171.193 387.059 172.755C382.224 175.681 376.76 177.418 371.119 177.824C364.255 179.726 357.305 181.314 350.29 182.54L345.915 183.292C341.984 183.964 337.953 184.656 333.953 185.453C334.528 185.624 335.105 185.786 335.679 185.987C342.807 188.49 348.953 193.189 353.228 199.407C357.504 205.623 359.688 213.035 359.464 220.572L332.041 228.97L356.856 232.901C354.585 238.467 350.938 243.368 346.255 247.146C341.572 250.925 336.005 253.457 330.075 254.508C324.145 255.557 318.044 255.09 312.344 253.151C306.644 251.211 301.529 247.861 297.478 243.414C297.73 244.256 297.982 245.097 298.237 245.937C298.741 247.604 299.24 249.263 299.72 250.906C306.25 273.291 303.439 290.9 291.806 300.486L285.493 292.862C296.816 283.53 293.303 264.301 290.203 253.668C289.732 252.055 289.24 250.425 288.745 248.787C284.492 234.691 279.671 218.713 285.915 204.031C295.326 181.902 322.448 177.268 344.241 173.546Z" fill="#F2F2F2"/>
                    <path d="M336.204 303.358H144.062C137.761 303.358 131.718 300.86 127.263 296.415C122.807 291.97 120.305 285.941 120.305 279.655V191.829C120.305 190.553 120.565 189.291 121.07 188.119C121.575 186.948 122.314 185.891 123.242 185.014L225.058 88.7235C229.128 84.8737 234.524 82.7278 240.133 82.7278C245.742 82.7278 251.138 84.8737 255.209 88.7235L352.285 180.531C354.71 182.824 356.641 185.586 357.961 188.65C359.281 191.712 359.962 195.01 359.962 198.344V279.655C359.962 282.767 359.347 285.85 358.153 288.725C356.959 291.602 355.209 294.214 353.003 296.415C350.797 298.616 348.177 300.362 345.296 301.553C342.413 302.745 339.324 303.358 336.204 303.358Z" fill="#303030"/>
                    <path opacity="0.1" d="M120.305 193.27H357.964V289.045C357.964 292.841 356.453 296.482 353.763 299.165C351.073 301.85 347.424 303.358 343.619 303.358H134.65C130.846 303.358 127.197 301.85 124.506 299.165C121.817 296.482 120.305 292.841 120.305 289.045V193.27Z" fill="#202020"/>
                    <path d="M315.185 117.803H164.582C157.363 117.803 151.51 123.643 151.51 130.845V281.1C151.51 288.303 157.363 294.142 164.582 294.142H315.185C322.404 294.142 328.256 288.303 328.256 281.1V130.845C328.256 123.643 322.404 117.803 315.185 117.803Z" fill="#4168D2"/>
                    <path opacity="0.1" d="M328.256 197.231V294.143H151.51V197.231L239.883 239.846L328.256 197.231Z" fill="#202020"/>
                    <path d="M239.884 245.325L126.649 190.722C125.949 190.384 125.174 190.229 124.398 190.272C123.621 190.314 122.867 190.553 122.208 190.965C121.549 191.378 121.006 191.951 120.629 192.63C120.253 193.308 120.056 194.072 120.056 194.849V288.796C120.056 290.675 120.426 292.537 121.147 294.273C121.869 296.009 122.925 297.588 124.257 298.917C125.589 300.246 127.171 301.299 128.911 302.019C130.651 302.738 132.517 303.108 134.401 303.108H345.367C347.251 303.108 349.116 302.738 350.856 302.019C352.597 301.299 354.178 300.246 355.51 298.917C356.842 297.588 357.899 296.009 358.62 294.273C359.341 292.537 359.713 290.675 359.713 288.796V196.458C359.713 195.511 359.471 194.579 359.012 193.751C358.552 192.922 357.89 192.223 357.086 191.72C356.281 191.217 355.362 190.925 354.414 190.873C353.466 190.821 352.521 191.01 351.666 191.422L239.884 245.325Z" fill="#303030"/>
                    <path d="M216.168 133.993H166.738V140.967H216.168V133.993Z" fill="#F2F2F2"/>
                    <path d="M309.534 159.398H162.744V163.382H309.534V159.398Z" fill="#F2F2F2"/>
                    <path d="M309.534 172.847H162.744V176.832H309.534V172.847Z" fill="#F2F2F2"/>
                    <path d="M309.534 186.296H162.744V190.282H309.534V186.296Z" fill="#F2F2F2"/>
                    <path d="M30.4336 303.108H441.844" stroke="#303030" stroke-miterlimit="10"/>
                    <path d="M0 241.77C0 271.14 18.4679 294.905 41.2905 294.905L0 241.77Z" fill="#454545"/>
                    <path d="M41.291 294.905C41.291 265.205 61.9001 241.172 87.3688 241.172L41.291 294.905Z" fill="#4168D2"/>
                    <path d="M14.96 244.432C14.96 272.33 26.7365 294.905 41.2901 294.905L14.96 244.432Z" fill="#4168D2"/>
                    <path d="M41.291 294.905C41.291 256.955 65.1118 226.247 94.5498 226.247L41.291 294.905Z" fill="#454545"/>
                    <path d="M32.6045 295.28C32.6045 295.28 38.4602 295.1 40.2249 293.846C41.9896 292.592 49.2324 291.096 49.6702 293.106C50.1081 295.116 58.4702 303.106 51.8592 303.16C45.2481 303.213 36.4981 302.133 34.7368 301.062C32.9754 299.992 32.6045 295.28 32.6045 295.28Z" fill="#A8A8A8"/>
                    <path opacity="0.2" d="M51.9771 302.46C45.3661 302.513 36.616 301.433 34.8547 300.362C33.5134 299.547 32.9788 296.621 32.7999 295.272C32.6761 295.277 32.6045 295.28 32.6045 295.28C32.6045 295.28 32.9754 299.991 34.7368 301.062C36.4981 302.132 45.2481 303.213 51.8592 303.16C53.7675 303.144 54.4267 302.467 54.3905 301.464C54.1254 302.07 53.3976 302.449 51.9771 302.46Z" fill="#202020"/>
                    <path d="M359.342 81.081C359.042 83.7482 357.002 85.8968 356.247 88.4728C355.11 92.35 357.076 96.5106 359.766 99.5302C361.936 101.941 364.564 103.898 367.498 105.288C370.432 106.678 373.614 107.472 376.859 107.627C377.811 107.711 378.771 107.607 379.685 107.32C380.499 106.993 381.233 106.493 381.834 105.853C383.86 103.824 384.947 101.013 385.381 98.1815C385.814 95.3503 385.645 92.4659 385.476 89.6068C385.477 89.0158 385.37 88.4297 385.159 87.8774C384.883 87.3512 384.503 86.8858 384.043 86.5089C382.584 85.1741 380.978 84.0098 379.255 83.0386C378.476 82.6904 377.789 82.166 377.248 81.507C376.923 80.9423 376.712 80.3192 376.628 79.6732L376.099 76.9839C376.005 76.2088 375.74 75.4643 375.322 74.8037C374.388 73.5461 372.601 73.3749 371.033 73.3136L365.288 73.0888C363.502 73.0188 361.147 72.5077 359.403 72.8577C357.774 73.1847 358.315 74.6823 358.611 76.0458C359.04 77.6922 359.285 79.3808 359.342 81.081Z" fill="#FFCDD3"/>
                    <path opacity="0.1" d="M359.342 81.081C359.042 83.7482 357.002 85.8968 356.247 88.4728C355.11 92.35 357.076 96.5106 359.766 99.5302C361.936 101.941 364.564 103.898 367.498 105.288C370.432 106.678 373.614 107.472 376.859 107.627C377.811 107.711 378.771 107.607 379.685 107.32C380.499 106.993 381.233 106.493 381.834 105.853C383.86 103.824 384.947 101.013 385.381 98.1815C385.814 95.3503 385.645 92.4659 385.476 89.6068C385.477 89.0158 385.37 88.4297 385.159 87.8774C384.883 87.3512 384.503 86.8858 384.043 86.5089C382.584 85.1741 380.978 84.0098 379.255 83.0386C378.476 82.6904 377.789 82.166 377.248 81.507C376.923 80.9423 376.712 80.3192 376.628 79.6732L376.099 76.9839C376.005 76.2088 375.74 75.4643 375.322 74.8037C374.388 73.5461 372.601 73.3749 371.033 73.3136L365.288 73.0888C363.502 73.0188 361.147 72.5077 359.403 72.8577C357.774 73.1847 358.315 74.6823 358.611 76.0458C359.04 77.6922 359.285 79.3808 359.342 81.081Z" fill="#202020"/>
                    <path d="M395.884 201.136C395.07 210.039 394.256 218.94 393.442 227.84C392.806 234.843 392.156 241.877 390.906 248.79C390.475 251.173 389.969 253.543 389.369 255.893C387.7 262.418 385.279 268.794 384.499 275.483C384.473 275.675 384.453 275.871 384.433 276.068C384.345 277.548 384.064 279.009 383.599 280.415C383.208 281.436 382.608 282.367 382.185 283.376C381.341 285.393 381.23 287.624 381.128 289.81C378.164 288.148 374.92 287.041 371.556 286.546C369.932 286.304 368.123 286.132 367.018 284.922C365.793 283.585 365.928 281.539 366.134 279.743C366.779 274.166 367.423 268.592 368.065 263.021C368.275 260.623 368.683 258.247 369.286 255.917C369.508 255.143 369.775 254.38 370.047 253.617C370.42 252.567 370.799 251.518 371.083 250.439C371.491 248.696 371.777 246.928 371.937 245.145C372.599 239.535 373.397 233.938 374.096 228.332L374.132 228.036C375.18 219.54 375.977 211.002 375.748 202.444C375.715 201.177 375.661 199.91 375.579 198.638C375.464 196.797 375.296 195.821 376.825 194.669C378.513 193.397 380.737 192.508 382.67 191.675C383.709 191.224 395.16 187.169 395.428 188.059C395.965 189.957 396.247 191.918 396.266 193.89C396.274 196.31 396.147 198.73 395.884 201.136Z" fill="#454545"/>
                    <path opacity="0.1" d="M390.906 248.79C390.475 251.173 389.97 253.543 389.369 255.893C387.7 262.418 385.279 268.794 384.499 275.483C384.474 275.675 384.453 275.871 384.433 276.068C379.328 268.794 375.029 260.969 370.047 253.617C370.421 252.567 370.799 251.517 371.083 250.439C371.491 248.696 371.777 246.928 371.938 245.145C372.599 239.535 373.397 233.938 374.096 228.332L374.132 228.036C374.425 229.227 374.842 230.383 375.378 231.485C378.724 238.268 386.673 241.696 390.562 248.187C390.681 248.388 390.796 248.589 390.906 248.79Z" fill="#202020"/>
                    <path d="M349.483 189.149C349.652 194.589 350.524 199.98 351.395 205.353L353.193 216.439C354.175 222.506 355.2 228.696 358.078 234.13C360.23 238.194 363.332 241.664 366.138 245.311C373.036 254.276 378.217 264.432 384.758 273.66C386.659 276.343 389.376 279.244 392.621 278.683C394.75 278.315 396.298 276.547 397.971 275.183C399.945 273.576 402.323 272.399 403.876 270.383C405.429 268.368 405.733 265.018 403.629 263.584C402.868 263.163 402.06 262.834 401.221 262.601C397.96 261.364 395.849 258.187 394.507 254.974C393.164 251.761 392.35 248.306 390.56 245.319C386.673 238.827 378.722 235.399 375.375 228.614C373.501 224.813 373.323 220.434 373.179 216.2L372.814 205.41C372.774 204.23 372.743 203.003 373.224 201.924C374.503 199.052 378.369 198.785 381.498 198.42C385.051 198.005 388.491 196.922 391.639 195.228C393.441 194.257 395.202 193.019 396.166 191.216C397.046 189.571 397.167 187.642 397.271 185.779L398.355 166.224C398.448 164.542 398.533 162.801 397.939 161.225C396.446 157.264 391.434 155.97 387.197 156.159C379.313 156.51 372.035 159.894 364.601 162.179C362.76 162.758 360.892 163.245 359.001 163.637C357.333 163.97 355.314 163.832 353.723 164.367C350.893 165.318 350.965 171.492 350.564 174.053C349.736 179.041 349.373 184.095 349.483 189.149Z" fill="#454545"/>
                    <path d="M391.551 279.503C392.246 280.203 392.474 281.228 392.655 282.196C393.659 287.568 394.181 293.018 394.216 298.482C394.169 298.991 394.271 299.504 394.51 299.957C394.706 300.227 394.97 300.44 395.277 300.572C397.287 301.528 399.619 300.196 401.293 298.733C404.396 296.02 407.023 292.379 407.199 288.267C407.167 287.207 407.204 286.147 407.31 285.092C407.583 283.544 408.49 282.195 409.288 280.84C410.647 278.533 411.743 276.081 412.556 273.531C412.861 272.574 413.064 271.367 412.312 270.698C412.045 270.49 411.742 270.333 411.417 270.235L402.341 266.873C401.554 266.581 399.597 271.596 399.287 272.145C398.526 273.486 397.771 274.247 396.247 274.557C394.69 274.874 392.838 274.42 391.387 275.195C388.931 276.505 390.161 278.104 391.551 279.503Z" fill="#454545"/>
                    <path d="M377.547 282.599C377.377 282.263 377.143 281.966 376.856 281.725C376.436 281.458 375.958 281.297 375.462 281.252C373.734 280.96 371.686 280.767 370.493 282.048C369.375 283.25 369.568 285.206 368.633 286.555C368.337 286.982 367.936 287.333 367.68 287.785C367.361 288.475 367.218 289.233 367.261 289.992C367.213 292.081 367.164 294.174 367.31 296.26C367.431 298.007 367.726 299.838 368.822 301.207C370.579 303.404 373.75 303.72 376.564 303.864L378.844 303.979C379.472 304.054 380.108 303.997 380.712 303.808C381.085 303.635 381.42 303.39 381.697 303.086C381.974 302.783 382.187 302.426 382.323 302.039C383.51 299.097 381.63 295.927 380.473 292.973C379.143 289.579 379.382 285.808 377.547 282.599Z" fill="#454545"/>
                    <path d="M358.682 66.052C358.653 65.7538 358.698 65.4532 358.81 65.1753C359.144 64.5864 360.016 64.7467 360.673 64.9121C363.318 65.5773 366.104 64.9751 368.827 65.1306C371.55 65.2859 374.617 66.644 375.165 69.3097C377.141 67.9118 378.845 66.1653 380.192 64.1563C380.948 63.028 381.606 61.7357 381.503 60.3826C381.355 58.4309 379.714 56.9713 378.194 55.7336L373.664 52.0439C373.069 51.4988 372.382 51.0631 371.636 50.7574C370.589 50.4007 369.448 50.5707 368.343 50.5714C365.046 50.5735 361.53 49.0761 358.597 50.5803C357.372 51.2086 356.45 52.2853 355.561 53.335L351.517 58.1102C351.213 58.4145 350.991 58.7906 350.872 59.2036C350.756 59.7864 351.056 60.3617 351.16 60.9465C351.351 62.0132 350.891 63.1516 351.245 64.1761C351.833 65.8768 353.903 66.1175 355.168 67.0925C355.64 67.4559 356.379 68.6873 356.941 68.6723C357.955 68.6452 358.656 66.8379 358.682 66.052Z" fill="#303030"/>
                    <path d="M365.542 80.1273C372.692 80.1273 378.489 74.344 378.489 67.21C378.489 60.076 372.692 54.2927 365.542 54.2927C358.391 54.2927 352.595 60.076 352.595 67.21C352.595 74.344 358.391 80.1273 365.542 80.1273Z" fill="#FFCDD3"/>
                    <path d="M368.574 95.4798C368.134 94.2244 367.306 93.1413 366.208 92.3876C365.111 91.6337 363.801 91.2485 362.468 91.2876C362.087 91.3584 361.694 91.3087 361.342 91.1455C361.143 90.9932 360.985 90.7951 360.879 90.5681C360.092 89.1557 359.459 87.6629 358.991 86.1156C358.785 85.4319 358.502 84.6259 357.809 84.4481C357.522 84.4107 357.23 84.4517 356.965 84.5669C356.699 84.682 356.47 84.8671 356.302 85.1022C355.972 85.5752 355.613 86.0264 355.225 86.4528C353.597 87.9054 350.71 86.5815 348.981 87.9141C348.699 88.1318 348.466 88.4106 348.17 88.6087C347.873 88.7869 347.553 88.9237 347.219 89.0153C343.882 90.1023 340.609 91.3808 337.42 92.8443C338.569 99.7518 339.748 106.78 342.443 113.245C343.725 116.322 345.179 119.336 346.205 122.506C348.48 129.531 348.581 137.048 348.606 144.431C348.625 149.484 348.599 154.646 346.96 159.427C346.52 160.484 346.209 161.589 346.035 162.721C345.936 163.86 346.268 165.116 347.194 165.792C347.731 166.141 348.344 166.357 348.982 166.418C351.821 166.833 354.684 166.08 357.479 165.433C364.973 163.702 372.616 162.712 380.243 161.724L393.024 160.067C393.94 160.006 394.837 159.775 395.669 159.386C398.008 158.108 398.23 154.598 396.777 152.367C396.082 151.298 395.099 150.42 394.514 149.286C393.928 148.152 393.879 146.566 394.886 145.781C396.935 144.184 396.324 141.219 396.421 138.627C396.695 131.377 396.657 124.126 396.311 116.871C396.208 115.369 396.184 113.864 396.238 112.359C396.465 109.811 396.937 107.289 397.648 104.829L401.531 89.5731C400.517 87.9735 398.574 86.9587 396.734 86.4979C394.894 86.0371 392.977 85.9016 391.165 85.3412C387.452 84.1934 384.147 81.2805 380.269 81.5519C379.976 81.5572 379.688 81.6275 379.425 81.7577C378.55 82.2519 378.689 83.5093 378.633 84.5105C378.509 86.7256 376.876 88.577 375.073 89.875C373.269 91.173 371.21 92.1194 369.553 93.5997C369.26 93.8204 369.02 94.1038 368.851 94.429C368.681 94.7543 368.587 95.1134 368.574 95.4798Z" fill="#303030"/>
                    <path d="M317.273 109.951C316.414 110.507 315.502 110.975 314.55 111.35C313.617 111.627 312.736 112.053 311.941 112.612C311.574 112.928 311.267 113.307 311.033 113.73C310.595 114.506 310.373 115.385 310.392 116.274C310.41 117.165 310.667 118.034 311.137 118.79C311.607 119.548 312.271 120.165 313.061 120.578C313.852 120.991 314.739 121.186 315.629 121.14C316.814 121.007 317.964 120.665 319.028 120.128L328.16 116.18C329.706 115.513 331.376 114.729 332.106 113.215C332.191 113.074 332.222 112.907 332.195 112.745C332.121 112.573 331.988 112.433 331.82 112.351C329.76 111.017 327.959 109.322 326.503 107.348C326.128 106.841 325.67 105.642 325.14 105.338C323.207 104.229 318.82 108.95 317.273 109.951Z" fill="#FFCDD3"/>
                    <path d="M414.897 106.712L418.264 110.549C418.986 111.372 419.711 112.197 420.369 113.073C421.987 115.297 423.285 117.737 424.225 120.32C424.957 122.236 425.564 124.277 425.309 126.311C425.139 127.354 424.856 128.376 424.467 129.358C423.849 131.247 423.085 133.085 422.179 134.856C421.417 136.2 420.557 137.487 419.605 138.705C416.998 142.151 414.146 145.406 411.07 148.444C409.919 149.581 409.436 151.419 408.935 152.955C408.011 155.789 405.812 157.997 403.685 160.09C403.002 160.81 402.247 161.458 401.432 162.026C400.21 162.811 398.782 163.216 397.329 163.191C396.693 163.195 396.064 163.065 395.481 162.81C394.027 162.12 393.286 160.441 393.135 158.841C393 157.389 393.244 155.927 393.843 154.596C395.775 150.326 400.736 148.476 404.243 145.361C406.299 143.534 407.872 141.24 409.423 138.97C410.476 137.552 411.356 136.015 412.042 134.389C412.826 132.303 412.521 129.836 413.204 127.716C413.494 126.82 414.008 126.012 414.319 125.124C414.63 124.235 414.708 123.18 414.165 122.411C413.754 121.923 413.231 121.54 412.64 121.298C410.4 120.164 407.891 118.703 407.463 116.234C407.291 114.864 407.65 113.482 408.465 112.367C409.277 111.266 410.227 110.274 411.29 109.413C412.27 108.548 413.917 107.576 414.897 106.712Z" fill="#FFCDD3"/>
                    <path d="M315.112 115.308C314.517 114.109 313.774 112.887 312.575 112.291C311.993 112.04 311.366 111.908 310.732 111.905C310.098 111.903 309.47 112.029 308.886 112.276C307.723 112.776 306.634 113.433 305.649 114.228L302.748 116.363C302.09 116.794 301.507 117.33 301.025 117.95C300.567 118.701 300.262 119.536 300.128 120.406C299.622 122.389 299.467 124.445 299.671 126.481C300.132 129.746 302.104 132.596 304.277 135.082C305.633 136.634 307.309 138.202 309.373 138.268C310.264 138.297 311.255 137.946 311.625 137.137C311.754 136.817 311.821 136.476 311.826 136.13C312.05 132.488 310.744 128.931 309.221 125.615C308.735 124.746 308.448 123.78 308.38 122.789C308.369 122.621 308.414 122.455 308.504 122.315C308.636 122.179 308.812 122.093 309 122.074C311.084 121.663 314.673 123.278 316.136 120.969C317.083 119.472 315.785 116.665 315.112 115.308Z" fill="#FFCDD3"/>
                    <path d="M358.003 61.9874C357.974 61.6891 358.019 61.3885 358.131 61.1106C358.464 60.5216 359.337 60.6819 359.994 60.8473C362.639 61.5125 365.425 60.9104 368.148 61.0658C370.871 61.2212 373.938 62.5793 374.486 65.2449C376.462 63.847 378.166 62.1006 379.512 60.0916C380.269 58.9633 380.927 57.671 380.824 56.3179C380.676 54.3663 379.035 52.9067 377.514 51.6688L372.985 47.9792C372.39 47.4341 371.703 46.9985 370.957 46.6926C369.91 46.336 368.769 46.5059 367.664 46.5066C364.367 46.5087 360.851 45.0114 357.918 46.5156C356.693 47.1439 355.771 48.2205 354.882 49.2704L350.838 54.0454C350.534 54.3497 350.312 54.7259 350.192 55.1389C350.077 55.7217 350.377 56.2969 350.481 56.8818C350.672 57.9485 350.212 59.0869 350.566 60.1114C351.154 61.812 353.223 62.0528 354.489 63.0278C354.961 63.3912 355.7 64.6227 356.261 64.6076C357.276 64.5806 357.976 62.7732 358.003 61.9874Z" fill="#303030"/>
                    <path d="M330.504 97.387C329.981 97.7233 329.522 98.1495 329.148 98.6456C328.674 99.3617 328.577 100.266 328.17 101.022C327.297 102.639 325.256 103.215 323.982 104.542C323.78 104.725 323.64 104.965 323.58 105.231C323.574 105.591 323.695 105.942 323.923 106.221L330.062 115.851C332.107 116.031 334.067 114.753 336.112 114.923C336.876 114.986 337.657 115.249 338.39 115.024C338.914 114.792 339.405 114.493 339.851 114.132C341.071 113.363 342.696 113.273 343.719 112.258C344.702 111.283 344.827 109.758 344.815 108.377C344.831 107.176 344.709 105.978 344.45 104.806C343.547 101.11 340.713 98.2731 338.937 94.9989C338.071 93.4049 337.602 92.4718 335.771 93.5663C333.932 94.6665 332.235 96.1236 330.504 97.387Z" fill="#303030"/>
                    <path d="M405.068 92.5174C406.221 93.2648 407.262 94.1738 408.156 95.2165C409.092 96.4198 409.622 97.8923 410.52 99.1231C411.391 100.316 412.576 101.24 413.564 102.339C415.063 104.004 416.077 106.037 417.074 108.043C414.639 111.21 411.986 114.202 409.132 116.998C408.814 117.371 408.396 117.646 407.926 117.788C407.606 117.823 407.284 117.777 406.986 117.656C406.689 117.535 406.425 117.342 406.221 117.096C405.779 116.632 405.466 116.061 405.043 115.582C404.045 114.555 402.716 113.913 401.29 113.77C399.876 113.633 398.454 113.614 397.037 113.711C396.725 113.747 396.41 113.693 396.129 113.56C395.919 113.414 395.748 113.219 395.633 112.992C393.97 110.17 394.505 106.627 395.091 103.407L396.438 96.0166C396.633 94.6053 397.008 93.2248 397.557 91.9095C398.067 90.8226 399.207 88.9796 400.608 89.3051C402.021 89.633 403.879 91.6644 405.068 92.5174Z" fill="#303030"/>
                    <path d="M158.75 141.041C170.055 141.041 179.221 131.88 179.221 120.581C179.221 109.28 170.055 100.12 158.75 100.12C147.444 100.12 138.279 109.28 138.279 120.581C138.279 131.88 147.444 141.041 158.75 141.041Z" fill="white"/>
                    <path d="M158.75 96.6331C153.911 96.6331 149.181 98.0646 145.159 100.747C141.135 103.429 137.999 107.241 136.147 111.701C134.296 116.161 133.811 121.069 134.755 125.803C135.699 130.538 138.029 134.887 141.451 138.301C144.873 141.714 149.232 144.039 153.978 144.981C158.723 145.923 163.642 145.439 168.112 143.592C172.583 141.745 176.403 138.616 179.092 134.602C181.78 130.589 183.215 125.869 183.215 121.041C183.196 114.573 180.613 108.376 176.029 103.803C171.444 99.2297 165.233 96.6519 158.75 96.6331ZM153.728 134.056L141.189 121.546L144.706 118.038L153.739 127.05L172.806 108.028L176.322 111.537L153.727 134.056H153.728Z" fill="#5FB857"/>
                    </g>
                    <defs>
                    <clipPath id="clip0_46_1104">
                    <rect width="506" height="304" fill="white"/>
                    </clipPath>
                    </defs>
                </svg>
            </div>
        </div>
    </section>
    <div class="popupResponse">
        <div class="popupResponseBg"></div>

        <div class="popupResponseItem">

            <svg width="97" height="96" viewBox="0 0 97 96" fill="none" xmlns="http://www.w3.org/2000/svg"><circle opacity="0.12" cx="48.5" cy="48.0001" r="48" fill="#27AE60"/><g clip-path="url(#clip0_2669_4694)"><path d="M36.9847 49.0672C36.3679 48.557 35.5642 48.2802 34.7347 48.2923C33.9053 48.3044 33.1116 48.6045 32.5126 49.1323C31.9137 49.6602 31.554 50.3769 31.5056 51.1385C31.4572 51.9001 31.7237 52.6504 32.2517 53.2389L39.5484 60.2824C39.8539 60.5772 40.221 60.8121 40.6276 60.9732C41.0343 61.1342 41.4721 61.218 41.9149 61.2196C42.3553 61.2219 42.7917 61.1429 43.1982 60.9871C43.6047 60.8313 43.9731 60.6019 44.2814 60.3127L66.5659 39.1518C66.8681 38.866 67.106 38.5282 67.2662 38.1578C67.4265 37.7874 67.5058 37.3916 67.4997 36.993C67.4936 36.5944 67.4022 36.2008 67.2307 35.8347C67.0592 35.4685 66.811 35.1371 66.5002 34.8592C66.1894 34.5813 65.8222 34.3624 65.4194 34.2151C65.0167 34.0677 64.5863 33.9948 64.1529 34.0004C63.7195 34.006 63.2916 34.0901 62.8935 34.2478C62.4955 34.4055 62.1351 34.6338 61.8329 34.9197L41.9477 53.8435L36.9847 49.0672Z" fill="#27AE60"/></g><defs><clipPath id="clip0_2669_4694"><rect width="96" height="96" fill="white" transform="translate(0.5)"/></defs></svg>

            <br><br>

            <p class="popupResponseText">Вы успешно отправили форму!</p>
            <p class="popupResponseText">Ожидайте ответа на почту.</p>

        </div>
    </div>
@endsection
