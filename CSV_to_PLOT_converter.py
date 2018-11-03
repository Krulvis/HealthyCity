#!/usr/bin/env python
# coding: utf-8

# In[39]:


import pandas as pd
import matplotlib
import matplotlib.pyplot as plt
import numpy as np
from scipy.optimize import curve_fit
from scipy.interpolate import UnivariateSpline
from datetime import datetime, timedelta
import geojson
from descartes import PolygonPatch
import matplotlib.pyplot as plt
from mpl_toolkits.basemap import Basemap
import numpy as np


# In[48]:


def buurtNaam(buurtNaam , particle):
    if "Vondelpark" in buurtNaam: 
        data = createFuture(['Amsterdam-Vondelpark'], particle)
    else:
        data = createFuture(['Amsterdam-Stadhouderskade'], particle)
    #sort values by day (tijdstip)
    values = data[0].sort_values(by=['tijdstip'])

    #get lenght of the value array
    length = len(values)



    i = 0
    #convert value to CORRECT datatypes / split strings where necessary 

    tijdstip = values['tijdstip']
    values['tijdstip'] = [w.split(' ', 1)[0] for w in values['tijdstip']]
    problem = values['waarde']

    values['waarde'] = [w.replace(',' , '.') for w in values['waarde']]
    problem = pd.to_numeric(values['waarde'])

    #create plot x & y array
    time = [] # x
    problemVal=[] # y

    #fill set (x & y ) arrays
    while i < length :
        if i % 24 == 0:
            time.append(tijdstip.iloc[i])
            problemVal.append(problem.iloc[i])
        i += 1   

    #create plot    
    fig, ax = plt.subplots()

    # fill plot with x & y arrays
    ax.plot(time , problemVal)
    # set Labels
    ax.set(xlabel='Day', ylabel=values['component'].iloc[0],
           title= values['component'].iloc[0] + " in the air")

    my_xticks = ax.get_xticks()
    plt.xticks([my_xticks[0], my_xticks[-1]], visible=True, rotation="horizontal")

    return plt.show()

def createFuture(filters , problem): 
    
    #read DATA
    data = pd.read_csv('./export.csv', delimiter=";")
     
    #apply filter
    data = data.loc[
        (data['locatie'] == filters[0]) &
        (data['component'] == problem)
    ]
    
    #create return array
    returnVals = [data , problem]
    
    #return set array
    return returnVals







# In[10]:


plt.style.use('ggplot')


# In[53]:


buurtNaam('Vondelpark', 'O3')

