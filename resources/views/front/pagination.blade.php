@if ($paginator->hasPages())
    <style>
      .vs-pagination {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        gap: 8px;
        margin: 20px auto 10px;
      }
      .vs-pagination ul {
        display: inline-flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 6px;
        margin: 0;
        padding: 0;
        list-style: none;
      }
      .vs-pagination li {
        display: inline-block;
        margin: 0;
        list-style: none;
      }
      .vs-pagination a,
      .vs-pagination span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background: #f1f5f9;
        color: #1e293b;
        font-weight: 600;
        font-size: 15px;
        text-decoration: none;
        transition: all 0.2s ease;
        border: 1px solid #e2e8f0;
        line-height: 1;
      }
      .vs-pagination a:hover {
        background: #084b87;
        color: #ffffff !important;
        border-color: #084b87;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(8, 75, 135, 0.25);
      }
      .vs-pagination .active span,
      .vs-pagination span.active {
        background: #084b87 !important;
        color: #ffffff !important;
        border-color: #084b87 !important;
        box-shadow: 0 4px 10px rgba(8, 75, 135, 0.3);
      }
      .vs-pagination .pagi-btn {
        width: 44px;
        height: 44px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: #ffffff;
        color: #084b87;
        border: 1px solid #cbd5e1;
        font-size: 14px;
        transition: all 0.2s ease;
        text-decoration: none;
      }
      .vs-pagination .pagi-btn:hover:not(.disabled) {
        background: #084b87;
        color: #ffffff !important;
        border-color: #084b87;
        transform: translateY(-2px);
      }
      .vs-pagination .pagi-btn.disabled {
        background: #f8fafc;
        color: #94a3b8;
        border-color: #e2e8f0;
        cursor: not-allowed;
      }
      .vs-pagination svg {
        max-width: 16px;
        max-height: 16px;
      }
    </style>
    <div class="vs-pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="pagi-btn disabled" aria-disabled="true">
                <i class="fa-solid fa-chevron-left"></i>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="pagi-btn" aria-label="Previous">
                <i class="fa-solid fa-chevron-left"></i>
            </a>
        @endif

        {{-- Pagination Elements --}}
        <ul>
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active" aria-current="page"><span class="active">{{ $page }}</span></li>
                        @else
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </ul>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="pagi-btn" aria-label="Next">
                <i class="fa-solid fa-chevron-right"></i>
            </a>
        @else
            <span class="pagi-btn disabled" aria-disabled="true">
                <i class="fa-solid fa-chevron-right"></i>
            </span>
        @endif
    </div>
@endif
