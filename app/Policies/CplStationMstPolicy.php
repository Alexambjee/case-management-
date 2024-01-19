<?php

namespace App\Policies;

use App\Models\IROUser;
use App\Models\cpl_station_mst;
use Illuminate\Auth\Access\HandlesAuthorization;

class CplStationMstPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\IROUser  $iROUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(IROUser $iROUser)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\IROUser  $iROUser
     * @param  \App\Models\cpl_station_mst  $cplStationMst
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(IROUser $iROUser, cpl_station_mst $cplStationMst)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\IROUser  $iROUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(IROUser $iROUser)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\IROUser  $iROUser
     * @param  \App\Models\cpl_station_mst  $cplStationMst
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(IROUser $iROUser, cpl_station_mst $cplStationMst)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\IROUser  $iROUser
     * @param  \App\Models\cpl_station_mst  $cplStationMst
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(IROUser $iROUser, cpl_station_mst $cplStationMst)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\IROUser  $iROUser
     * @param  \App\Models\cpl_station_mst  $cplStationMst
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(IROUser $iROUser, cpl_station_mst $cplStationMst)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\IROUser  $iROUser
     * @param  \App\Models\cpl_station_mst  $cplStationMst
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(IROUser $iROUser, cpl_station_mst $cplStationMst)
    {
        //
    }
}
