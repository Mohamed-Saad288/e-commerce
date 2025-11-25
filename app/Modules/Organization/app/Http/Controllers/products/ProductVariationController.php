<?php

namespace App\Modules\Organization\app\Http\Controllers\products;

use App\Http\Controllers\Controller;
use App\Modules\Organization\app\Models\ProductVariation\ProductVariation;
use Illuminate\Http\Request;

class ProductVariationController extends Controller
{
    /**
     * Get single variation data for quick edit
     */
    public function show($id)
    {
        $variation = ProductVariation::whereOrganizationId(auth('organization_employee')->user()->organization_id)
            ->findOrFail($id);

        // Get images
        $mainImages = $variation->getMedia('main_images')->map(function($media) {
            return [
                'id' => $media->id,
                'url' => $media->getUrl(),
            ];
        });

        $additionalImages = $variation->getMedia('additional_images')->map(function($media) {
            return [
                'id' => $media->id,
                'url' => $media->getUrl(),
            ];
        });

        return response()->json([
            'id' => $variation->id,
            'sku' => $variation->sku,
            'barcode' => $variation->barcode,
            'cost_price' => $variation->cost_price,
            'selling_price' => $variation->selling_price,
            'stock_quantity' => $variation->stock_quantity,
            'discount' => $variation->discount,
            'tax_amount' => $variation->tax_amount,
            'main_images' => $mainImages,
            'additional_images' => $additionalImages,
        ]);
    }

    /**
     * Update variation via quick edit
     */
    public function update(Request $request, $id)
    {
        $variation = ProductVariation::whereOrganizationId(auth('organization_employee')->user()->organization_id)
            ->findOrFail($id);

        $validated = $request->validate([
            'sku' => 'required|string|max:255',
            'barcode' => 'nullable|string|max:255',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'discount' => 'nullable|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
        ]);

        // Calculate total price
        $totalPrice = $validated['selling_price'] - ($validated['discount'] ?? 0) + ($validated['tax_amount'] ?? 0);

        $variation->update(array_merge($validated, [
            'total_price' => $totalPrice,
        ]));

        // Handle main images
        if ($request->has('main_images_existing')) {
            // Get IDs of images to keep
            $keepIds = $request->input('main_images_existing', []);

            // Delete images not in the keep list
            $variation->getMedia('main_images')->each(function($media) use ($keepIds) {
                if (!in_array($media->id, $keepIds)) {
                    $media->delete();
                }
            });
        } else {
            // No existing images selected, delete all
            $variation->clearMediaCollection('main_images');
        }

        // Add new main images
        if ($request->hasFile('main_images')) {
            foreach ($request->file('main_images') as $image) {
                $variation->addMedia($image)->toMediaCollection('main_images');
            }
        }

        // Handle additional images
        if ($request->has('additional_images_existing')) {
            $keepIds = $request->input('additional_images_existing', []);

            $variation->getMedia('additional_images')->each(function($media) use ($keepIds) {
                if (!in_array($media->id, $keepIds)) {
                    $media->delete();
                }
            });
        } else {
            $variation->clearMediaCollection('additional_images');
        }

        // Add new additional images
        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $image) {
                $variation->addMedia($image)->toMediaCollection('additional_images');
            }
        }

        return response()->json([
            'success' => true,
            'message' => __('messages.updated'),
        ]);
    }

    /**
     * Delete a variation
     */
    public function destroy($id)
    {
        $variation = ProductVariation::whereOrganizationId(auth('organization_employee')->user()->organization_id)
            ->findOrFail($id);

        $variation->delete();

        return response()->json([
            'success' => true,
            'message' => __('messages.deleted_successfully'),
        ]);
    }
}
