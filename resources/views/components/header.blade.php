<div class="nk-block-head nk-block-head-sm">

    @isset($back)
        <div class="nk-block-head-sub">
            <a class="back-to" href="{{ $back["url"] }}">
                <em class="icon ni ni-arrow-left"></em>
                <span>{{ $back["label"] }}</span>
            </a>
        </div>
    @endisset

    <div class="nk-block-between">


        <div class="nk-block-head-content">
            <h3 class="nk-block-title page-title">{{ $title }}</h3>
        </div>

        <div class="nk-block-head-content">
            <div class="toggle-wrap nk-block-tools-toggle">
                <a href="javascript:void(0)" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu">
                    <em class="icon ni ni-more-v"></em>
                </a>
                <div class="toggle-expand-content" data-content="pageMenu">
                    <ul class="nk-block-tools g-3">

                        @isset($btn)

                            <li class="nk-block-tools-opt">
                                <a href="{{ $btn['url'] }}" class="btn btn-primary">
                                    <span>
                                        {{ $btn["label"] }}
                                    </span>
                                </a>
                            </li>

                        @endisset

                    </ul>
                </div>
            </div>
        </div>

    </div>

</div>
