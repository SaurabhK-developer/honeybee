

<?php $__env->startSection('title', 'Buy and sell locally | Honeybee Marketplace'); ?>

<?php $__env->startSection('content'); ?>
<section class="hero py-5">
    <div class="container py-lg-4">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <span class="eyebrow">YOUR NEIGHBOURHOOD MARKETPLACE</span>
                <h1 class="display-5 fw-bold mt-3">Find it. Love it.<br><span class="text-honey">Pass it on.</span></h1>
                <p class="lead text-secondary mt-3">Discover pre-loved finds, useful services and great deals from people around you.</p>
            </div>
            <div class="col-lg-6">
                <form class="search-panel row g-2" method="GET" action="<?php echo e(route('marketplace.home')); ?>">
                    <div class="col-12">
                        <label class="form-label small fw-semibold" for="search-q">What are you looking for?</label>
                        <input id="search-q" class="form-control form-control-lg" type="search" name="q" value="<?php echo e(old('q', request('q'))); ?>" placeholder="Try “bicycle” or “tutoring”">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold" for="search-city">City</label>
                        <input id="search-city" class="form-control" type="text" name="city" value="<?php echo e(old('city', request('city'))); ?>" placeholder="Any city">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold" for="search-category">Category</label>
                        <select id="search-category" class="form-select" name="category_id">
                            <option value="">All categories</option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($parent->id); ?>" <?php if((string) request('category_id') === (string) $parent->id): ?> selected <?php endif; ?>><?php echo e($parent->name); ?></option>
                                <?php $__currentLoopData = $parent->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($child->id); ?>" <?php if((string) request('category_id') === (string) $child->id): ?> selected <?php endif; ?>><?php echo e($parent->name); ?> · <?php echo e($child->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-12 d-grid mt-3">
                        <button class="btn btn-honey btn-lg" type="submit">Search listings</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="container py-5">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-end gap-2 mb-4">
        <div>
            <span class="eyebrow">THE LATEST FINDS</span>
            <h2 class="h3 fw-bold mt-1 mb-0">Listings near you</h2>
        </div>
        <span class="text-muted small"><?php echo e($listings->total()); ?> <?php echo e($listings->total() === 1 ? 'listing' : 'listings'); ?></span>
    </div>

    <form class="filter-bar row g-2 align-items-end mb-4" method="GET" action="<?php echo e(route('marketplace.home')); ?>">
        <div class="col-6 col-md-2">
            <label class="form-label small" for="filter-type">Listing type</label>
            <select class="form-select form-select-sm" id="filter-type" name="type">
                <option value="">Any type</option>
                <option value="product" <?php if(request('type') === 'product'): ?> selected <?php endif; ?>>Products</option>
                <option value="service" <?php if(request('type') === 'service'): ?> selected <?php endif; ?>>Services</option>
            </select>
        </div>
        <div class="col-6 col-md-2">
            <label class="form-label small" for="filter-min">Min price</label>
            <input class="form-control form-control-sm" id="filter-min" name="min_price" type="number" min="0" step="0.01" value="<?php echo e(request('min_price')); ?>" placeholder="0">
        </div>
        <div class="col-6 col-md-2">
            <label class="form-label small" for="filter-max">Max price</label>
            <input class="form-control form-control-sm" id="filter-max" name="max_price" type="number" min="0" step="0.01" value="<?php echo e(request('max_price')); ?>" placeholder="No limit">
        </div>
        <?php $__currentLoopData = ['q', 'city', 'category_id']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(request($filter)): ?>
                <input type="hidden" name="<?php echo e($filter); ?>" value="<?php echo e(request($filter)); ?>">
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <div class="col-6 col-md-2">
            <button class="btn btn-outline-dark btn-sm w-100" type="submit">Apply filters</button>
        </div>
        <div class="col-6 col-md-2">
            <a class="btn btn-link btn-sm text-muted" href="<?php echo e(route('marketplace.home')); ?>">Clear filters</a>
        </div>
    </form>

    <?php if($listings->count()): ?>
        <div class="row g-4">
            <?php $__currentLoopData = $listings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $listing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <a class="listing-card card h-100 text-decoration-none" href="<?php echo e(route('marketplace.listings.show', $listing->id)); ?>">
                        <?php if($listing->image_path): ?>
                            <img class="card-img-top listing-image" src="<?php echo e(asset('storage/'.$listing->image_path)); ?>" alt="<?php echo e($listing->name); ?>">
                        <?php else: ?>
                            <div class="listing-image image-placeholder"><span>🐝</span></div>
                        <?php endif; ?>
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start gap-2">
                                <span class="badge rounded-pill bg-light text-dark"><?php echo e($listing->type === 'service' ? 'Service' : 'Product'); ?></span>
                                <span class="small text-muted text-truncate"><?php echo e($listing->category->name); ?></span>
                            </div>
                            <h3 class="h6 fw-semibold mt-3 mb-2 text-dark"><?php echo e($listing->name); ?></h3>
                            <p class="price mb-2">₹<?php echo e(number_format((float) $listing->price, 2)); ?></p>
                            <p class="small text-muted mt-auto mb-0"><?php echo e($listing->city); ?>, <?php echo e($listing->state); ?></p>
                        </div>
                    </a>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="mt-4"><?php echo e($listings->links()); ?></div>
    <?php else: ?>
        <div class="empty-state text-center py-5">
            <div class="display-5">🔎</div>
            <h3 class="h5 fw-bold mt-3">No listings match those filters yet</h3>
            <p class="text-muted">Try another search, or be the first to post something in your area.</p>
            <a class="btn btn-honey" href="<?php echo e(route('marketplace.listings.create')); ?>">Post a listing</a>
        </div>
    <?php endif; ?>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('marketplace.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\honeybee-marketplace\resources\views/marketplace/index.blade.php ENDPATH**/ ?>