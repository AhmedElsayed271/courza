@extends('frontend.layouts.master')

@section('title', 'Home')

@section('content')
    <div class="container">
        <!-- start Nav -->
        @include('frontend.includes.navbar')
        <!-- End Nav -->
        <!-- Start HomePage -->
        <main class="homePage row justify-content-center align-content-center">
            <!-- <div class="textContent text-center w-100 py-1 col-md-6">
                <h1 class="fw-bold"></h1>
            </div> -->
            <div class="image homeImg col-md-6">
                <img src="{{ asset('assets/frontend/images/homeimg.AVIF') }}" alt="homeimg" class="img-fluid">
            </div>
        </main>
        <!-- End HomePage -->
        <!-- Start BuyNow Btn -->
        <div class="buyNow text-center">
            @isset($courses[0]->id)
                <a href="{{ route('course.details', $courses[0]->id) }}"> <button class="btn main-btn fw-bold">اشتري الان
                    </button>
                </a>
            @else
                <a href="{{ route('home') }}"> <button class="btn main-btn fw-bold fs-5">اشتري الان
                    </button>
                </a>
            @endisset
        </div>
        <!-- End BuyNow Btn -->
        <!-- Start Icons Banner -->
        <div class="ImagesIcons text-center my-5 py-2">
            <div class="Icons row">
                <div class="icon my-3 col-6 col-md-4 col-lg-2 ">
                    <img src="{{ asset('assets/frontend/images/php.AVIF') }}" alt="phpIcon" width="60">
                </div>
                <div class="icon my-3 col-6 col-md-4 col-lg-2">
                    <img src="{{ asset('assets/frontend/images/js.AVIF') }}" alt="jsIcon" width="60">
                </div>
                <div class="icon my-3 col-6 col-md-4 col-lg-2">
                    <img src="{{ asset('assets/frontend/images/bootstrapIcon.AVIF') }}" alt="bootstrapIcon" width="60">
                </div>
                <div class="icon my-3 col-6 col-md-4 col-lg-2">
                    <img src="{{ asset('assets/frontend/images/react.AVIF') }}" alt="reactIcon" width="60">
                </div>
                <div class="icon my-3 col-6 col-md-4 col-lg-2">
                    <img src="{{ asset('assets/frontend/images/python.AVIF') }}" alt="pythonIcon" width="60">
                </div>
                <div class="icon my-3 col-6 col-md-4 col-lg-2">
                    <img src="{{ asset('assets/frontend/images/html.AVIF') }}" alt="htmlIcon" width="60">
                </div>
            </div>
        </div>
        <!-- End Icons Banner -->
        <!-- Scroll Btn -->
        <div class="scrollbtn display-none" id="scrollBtn">
            <button class="btn main-btn position-fixed ">
                <i class="fa-solid fa-caret-up"></i>
            </button>
        </div>
        <!-- End Scroll Btn -->
        <section class="whoUS row align-items-center" data-aos-delay="500">
            <div class="content col-md-6" data-aos="fade-left">
                <div class="title">
                    <h2 class="fw-bold">نبذة عن المنصة</h2>
                </div>
                <p class="py-3 lh-base fs-5"> إنها ليست مجرد منصة تعليمية بل هي بوابتك الشخصية لاكتساب المهارات التي تحتاجها للتألق في مجالات متنوعة، بدءًا من البرمجة وصولاً إلى التصميم والتسويق وغيرها.

عندما تختار منصتنا، ستجد نفسك في رحلة تعلم فريدة وممتعة. نحن نقدم دورات تعليمية تم تطويرها بعناية لتناسب احتياجات الدارسين من جميع الخلفيات والمستويات. سواء كنت مبتدئًا تبحث عن تعلم مهارة جديدة أو محترفًا يرغب في تطوير معرفته، فإن لدينا الدورات المناسبة لك</p>
            </div>
            <div class="image col-md-6 mx-auto" data-aos="fade-right" data-aos-delay="500">
                <img src="{{ asset('assets/frontend/images/img1.AVIF') }}" alt="image-1" class="rounded-2 course-image" />
            </div>
        </section>
        <!-- study Section -->
        <section class="studyPlan my-5 mx-1">
            <div class="title">
                <h2 class="fw-bold">خطط الدراسة</h2>
            </div>
            <div class="bg-white p-4 rounded">
    <h2 class="main-color ">أطلق إمكانياتك مع دوراتنا الرائعة</h2>

    <p class="fs-5 py-2 lh-lg">مرحبًا بك في موقع الويب الخاص بك، حيث يلتقي المعرفة بالتحول! تم تصميم دوراتنا بعناية لتمكينك، سواء كنت محترفًا متمرسًا يبحث عن تحسين مهاراته أو متعلمًا فضوليًا يتطلع لاستكشاف آفاق جديدة.</p>

    <h3 class="main-color">الميزات الرئيسية:</h3>
    <ul class="list-unstyled">
        <li class="fs-5 lh-lg">محتوى يقوده الخبراء: تعلم من خبراء الصناعة الذين يجلبون الخبرة في العالم الحقيقي إلى الفصل الدراسي الافتراضي.</li>
        <li class="fs-5 lh-lg">تعلم تفاعلي: تجمع دوراتنا بين النظرية والتمارين العملية والاختبارات والمناقشات للمحافظة على انخراطك طوال رحلة التعلم.</li>
        <li class="fs-5 lh-lg">جدول زمني مرن: الحياة مشغولة، ونحن نفهم ذلك. تم تصميم دوراتنا لتناسب جدولك الزمني، مما يتيح لك التعلم بالخطوة الخاصة بك.</li>
        <li class="fs-5 lh-lg">وصول مدى الحياة: بمجرد التسجيل، تحصل على وصول مدى الحياة إلى المواد الدراسية والتحديثات، مما يضمن بقاء معرفتك حديثة.</li>
    </ul>

    <h3 class="main-color">ما يميزنا:</h3>
    <ul class="list-unstyled">
        <li class="fs-5 lh-lg ">محتوى عالي الجودة: تم ترتيب دوراتنا بعناية فائقة لتوفير أحدث وأكثر المعلومات أهمية وتحديثًا في مجال اهتمامك.</li>
        <li class="fs-5 lh-lg ">دعم المجتمع: انضم إلى مجتمع نشط من المتعلمين، حيث يمكنك تبادل الأفكار وطرح الأسئلة وبناء اتصالات مع أفراد ذوي أفكار مماثلة.</li>
        <li class="fs-5 lh-lg ">نتائج مثبتة: خرج خريجونا لتحقيق نجاح كبير في مساراتهم المهنية. تحقق من قصص النجاح لدينا وانظر كيف قد أحدثت دوراتنا فارقًا.</li>
    </ul>

    <h3 class="main-color">تصفح دوراتنا:</h3>
    <p class="fs-5">استكشف مجموعتنا المتنوعة من الدورات التي تلبي مستويات واهتمامات مهارية مختلفة. سواء كنت مهتمًا بالتكنولوجيا أو الأعمال أو الفنون الإبداعية أو التطوير الشخصي، لدينا شيء للجميع.</p>


    <p class="fs-5">هل أنت جاهز لاتخاذ الخطوة التالية؟ تصفح دوراتنا وابدأ في مغامرة التعلم مع موقع الويب الخاص بك!</p>
</div>

        </section>
        <!-- End study Section -->
        <!-- Start courses Section -->
        <section class="courses" id='currentCourses'>
            <div class="title">
                <h2 class="fw-bold">الدورات الحاليه</h2>
            </div>
            <div class="courses row">
                @foreach ($courses as $course)
                    <div class="col-md-4 justify-content-center mx-auto">
                        <div class="w-100 course">
                            <a href="{{ route('course.details', $course->id) }}" class="w-100">
                                <div class="card p-0 cardCourse mt-4  mx-auto cursor-pointer border-0"
                                    data-aos="flip-left" data-aos-delay="500">
                                    <div class="courseImage">
                                        <img src="{{ $course->image }}" class="card-img" alt="PythonImg">
                                    </div>
                                    <div class="card-body ">
                                        <div class="cardContent">
                                            <h5 class="card-title fw-bold text-end ">{{ $course->name }}</h5>
                                            <p>{{ $course->descriptoin }}</p>
                                            <h3 class="fw-bold h6">السعر : <del>{{ $course->old_price }}</del>
                                                {{ $course->price }}
                                                <span class="text-start">EGP</span>
                                            </h3>
                                            @if (App\Models\Course::isUserBuyCourse($course->id))
                                                <div class="buy">
                                                    <a href="{{ route('video.course', $course->id) }}"><button
                                                            class="btn main-btn fw-bold">
                                                            مشاهده</button></a>
                                                </div>
                                            @else
                                                <div class="buy">
                                                    <a href="{{ route('checkout', $course->id) }}"><button
                                                            class="btn main-btn fw-bold">اشتري
                                                            الان</button></a>
                                                </div>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
        <!-- End courses Section -->
        <section class="mission my-5" id="ourTarget">
            <div class="missionText ">
                <div class="title">
                    <h2 class="fw-bold">اهدافنا</h2>
                </div>
                <p class="py-3 px-2 lh-base fs-5">
                    إن هدفنا الأسمى هو تمكينك ومساعدتك على تحقيق أهدافك المهنية. نؤمن بأن التعليم يجب أن يكون متاحًا للجميع، وهذا هو السبب في أننا نقدم دوراتنا بأسعار معقولة وبجودة عالية. نحن نركز على توفير تجربة تعليمية فريدة وشاملة تساعدك على التقدم في مسارك المهني.
عندما تختار منصتنا، ستكون جزءًا من مجتمع تعليمي متحفز يشجع على التفاعل والتعلم المشترك. ستتعرف على أشخاص آخرين يشاركونك نفس الاهتمامات والأهداف، وستستفيد من خلال تبادل الخبرات والمعرفة.

نحن نقدم دعمًا فعالًا للدارسين من خلال فريقنا المختص. سنقدم لكم المساعدة والتوجيه في كل مرحلة من مراحل رحلتك التعليمية. سواء كنت بحاجة إلى نصائح حول اختيار الدورات المناسبة أو مساعدة في حل المشكلات التي تواجهك أثناء التعلم، فإننا هنا لمساعدتك.
                </b>
            </div>
        </section>
        <section class="contactUs" id="contactUs">
            <div class="title">
                <h2 class="fw-bold">تواصل معنا</h2>
            </div>
            <div class="contactForm my-5">
                <form class="form my-3" action="{{ route('contact.create') }}" method="post">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6 my-2">
                            <input type="text" class="form-control" placeholder="الاسم" name="name" />
                        </div>
                        <div class="col-md-6 my-2">
                            <input type="email" class="form-control" placeholder="البريد الالكتروني" name="email" />
                        </div>
                    </div>
                    <div class="my-2">
                        <textarea class="form-control" placeholder="اترك استفسارك هنا وسيتم الرد عليك " name="message" rows="6"></textarea>
                    </div>
                    <button class="btn main-btn fw-bold" type="submit"> ارسال</button>
                </form>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (Session::has('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
        </section>
    </div>
@endsection
